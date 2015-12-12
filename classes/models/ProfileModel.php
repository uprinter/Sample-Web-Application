<?php
namespace models;

use entities\User;
use dao\DaoFactory;
use utils\PasswordManager;

/**
 * Class ProfileModel
 *
 * Implements model operations for user profile
 *
 * @package models
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class ProfileModel extends AbstractModel
{
    /**
     * @var \dao\FileDao $dao Instance of DAO
     */
    private $dao;

    /**
     * Public constructor
     */
    public function __construct() {
        $this->dao = DaoFactory::getUserDao();
    }

    /**
     * Updates user
     *
     * @param array $array Array of parameters
     */
    public function update(array $array) {
        $user = new User();
        $this->convertDates($array, ['birth_date']);
        $user->populate($array);
        $this->dao->save($user);
    }

    /**
     * Gets user by ID
     *
     * @param int $id User ID
     * @return null|\entities\User
     */
    public function get($id) {
        return $this->dao->get($id);
    }

    /**
     * Creates user
     *
     * @param array $array Array of parameters
     * @throws ModelException
     */
    public function create(array $array) {
        $user = new User();
        $this->convertDates($array, ['birth_date']);
        $user->populate($array);

        $existingUser = $this->dao->getUserByLogin($user->login);

        if (!is_null($existingUser)) {
            throw new ModelException('This login already exists');
        }

        $passwordManager = new PasswordManager();
        $salt = $passwordManager->getRandomSalt();
        $password = $passwordManager->getHash($array['password'], $salt);
        $user->password = $password;
        $user->salt = $salt;
        $this->dao->save($user);
    }
}