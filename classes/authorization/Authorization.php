<?php
namespace authorization;

use dao\DaoFactory;
use utils\PasswordManager;

/**
 * Singleton class Authorization
 *
 * Provides functionality for user authorization and session support
 *
 * @package authorization
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class Authorization {
    /**
     * @var string $sessionName User session name
     */
    private $sessionName;

    /**
     * @var string $domain Session domain
     */
    private $domain;

    /**
     * @var object|null $instance Stores instance of this class
     */
    private static $instance = null;

    /**
     * Defines "Session not started" state
     */
    const SESSION_NOT_STARTED = false;

    /**
     * @var bool $sessionState Stores session state
     */
    private $sessionState = self::SESSION_NOT_STARTED;

    /**
     * Initializes object of this class
     *
     * @param string $sessionName Session name
     * @param string $domain Session domain
     * @return Authorization Object of this class
     */
    public static function getInstance($sessionName, $domain = '') {
        if (is_null(self::$instance)) {
            self::$instance = new self;
            self::$instance->sessionName = $sessionName;
            self::$instance->domain = $domain;
        }

        return self::$instance;
    }

    /**
     * Private class constructor
     */
    private function __construct() {}

    /**
     * Starts session
     */
    public function startSession() {
        session_name($this->sessionName);
        $this->sessionState = session_start();
    }

    /**
     * Starts session and checks session state
     *
     * @throws AuthorizationException
     */
    public function start() {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->startSession();

            if ($this->sessionState) {
                if (!$this->isAuthorized()) {
                    // User is remembered?
                    $this->checkCookie();
                }
                else {
                    // Session is valid?
                    $this->checkSession();
                }
            }
            else {
                throw new AuthorizationException('Can\'t start the session');
            }
        }
    }

    /**
     * Returns whether user is authorized or not
     *
     * @return bool Is user authorized or not
     */
    public function isAuthorized() {
        return $this->getUserId() ? true : false;
    }

    /**
     * Gets authorized user ID
     *
     * @return bool User ID
     */
    public function getUserId() {
        if (isset($_SESSION[$this->sessionName]['user_id'])) {
            return $_SESSION[$this->sessionName]['user_id'];
        }

        return false;
    }

    /**
     * Makes user authorization
     *
     * @param string $login Login
     * @param string $password Password
     * @param bool|false $remember Remember flag state
     * @throws IncorrectPasswordException
     * @throws LoginNotFoundException
     */
    public function login($login, $password, $remember = false) {
        $login = trim($login);

        $user = DaoFactory::getUserDao()->getUserByLogin($login);

        if (!is_null($user)) {
            $psw = new PasswordManager();

            if ($user->getPassword() !== $psw->getHash($password, $user->getSalt())) {
                throw new IncorrectPasswordException('Incorrect password');
            }
            else {
                $id = $user->getId();
                $this->makeSession($id);

                if ($remember) {
                    $this->makeCookie('field1', $id);
                    $this->makeCookie('field2', $this->getSecretPhrase($id, $login, $password));
                }
            }
        }
        else {
            throw new LoginNotFoundException('User not found');
        }
    }

    /**
     * Kills user's session
     */
    public function logout() {
        $this->killSession();
    }

    /**
     * Checks user's session
     */
    private function checkSession() {
        if ($_SESSION[$this->sessionName]['fingerprint'] != $this->getFingerprint()) {
            $this->killSession();
        }
    }

    /**
     * Verifies user's cookies
     */
    private function checkCookie() {
        if (isset($_COOKIE['field1'][$this->sessionName]) && isset($_COOKIE['field2'][$this->sessionName])) {
            $user = DaoFactory::getUserDao()->get($_COOKIE["field1"][$this->sessionName]);

            if (!is_null($user)) {
                $id = $user->getId();

                if ($this->getSecretPhrase($id, $user->getEmail(),
                        $user->getPassword()) == $_COOKIE['field2'][$this->sessionName]) {
                    $this->makeSession($id, $user->getCompanyId());
                }
            }
        }
    }

    /**
     * Gets fingerprint to protect user's session
     *
     * @return string Fingerpring
     */
    private function getFingerprint() {
        return md5('my_lovely_prefix' . $_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * Gets secret phrase to protect user's cookie
     *
     * @param int $id User ID
     * @param string $login Login
     * @param string $password Password
     * @return string Secret phrase
     */
    private function getSecretPhrase($id, $login, $password) {
        return md5('topsecret_' . $id . '_'  .$login . '_' . $password);
    }

    /**
     * Creates user's session
     *
     * @param $id User ID
     */
    public function makeSession($id) {
        $_SESSION[$this->sessionName]['user_id'] = $id;
        $_SESSION[$this->sessionName]['fingerprint'] = $this->getFingerprint();
    }

    /**
     * Destroys user's session
     */
    private function killSession() {
        unset($_SESSION[$this->sessionName]);

        $this->killCookie('field1');
        $this->killCookie('field2');

        if (empty($_SESSION)) {
            $this->killSessionCookie();
            session_destroy();
        }
    }

    /**
     * Creates cookie
     *
     * @param string $name Cookie key
     * @param string $value Cookie value
     */
    private function makeCookie($name, $value) {
        setcookie($name . '[' . $this->sessionName . ']', $value, time() + 31536000, '/', $this->domain);
    }

    /**
     * Destroys cookie
     *
     * @param string $name Cookie name to kill
     */
    private function killCookie($name) {
        setcookie($name . '[' . $this->sessionName . ']', '', time() - 3600, '/', $this->domain);
    }

    /**
     * Destroys session's cookies
     */
    private function killSessionCookie() {
        unset($_COOKIE[$this->sessionName]);
        setcookie($this->sessionName, '', time() - 3600, '/', $this->domain);
    }
}