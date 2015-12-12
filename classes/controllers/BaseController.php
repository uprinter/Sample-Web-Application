<?php
namespace controllers;

use authorization\Authorization;

/**
 * Abstract class BaseController
 *
 * Provides base functionality for handling HTTP requests
 *
 * @package controllers
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
abstract class BaseController implements IController {
    /**
     * @var array $params Request params
     */
    private $params = [];

    /**
     * Instance of authorization class
     *
     * @var Authorization $auth;
     */
    protected $auth;

    /**
     * Public constructor
     *
     * @throws \authorization\AuthorizationException
     */
    public function __construct() {
        $this->auth = Authorization::getInstance(SESSION_NAME_DEFAULT, COOKIE_DOMAIN);

        try {
            $this->auth->start();
        }
        catch (AuthorizationException $e) {
            (new ErrorsController())->error503();
        }
    }

    /**
     * Sets request params
     *
     * @param array $params Request params
     */
    public function setParams(array $params) {
        $this->params = $params;
    }

    /**
     * Gets request params
     *
     * @return array Request params
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * Redirects user to URL
     *
     * @param string $url URL to redirect
     */
    public function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Redirects user to home page
     */
    public function goHome() {
        $this->redirect('/');
    }
}