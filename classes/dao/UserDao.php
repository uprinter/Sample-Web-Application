<?php
namespace dao;

use entities\User;

/**
 * Class UserDao
 *
 * Implements data access operations for users
 *
 * @package dao
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class UserDao extends DaoBase {
    /**
     * Gets user by ID
     *
     * @param int $id User ID
     * @return User|null User entity or null
     * @throws \db\DatabaseException
     */
    public function get($id) {
        $array = $this->db->getRow('select * from ' . DB_TABLE_USERS_VIEW . ' where id = ?', [$id]);

        if (!is_null($array)) {
            $entity = new User();
            $entity->populate($array);

            return $entity;
        }

        return null;
    }

    /**
     * Saves user
     *
     * @param User $user User entity
     * @return int New user ID or number of affected rows
     * @throws \db\DatabaseException
     */
    public function save(User $user) {
        $params = [];

        if (!is_null($user->id))
            $params['id'] = $user->id;
        if (!is_null($user->login))
            $params['login'] = $user->login;
        if (!is_null($user->password))
            $params['password'] = $user->password;
        if (!is_null($user->salt))
            $params['salt'] = $user->salt;
        if (!is_null($user->firstName))
            $params['first_name'] = $user->firstName;
        if (!is_null($user->lastName))
            $params['last_name'] = $user->lastName;
        if (!is_null($user->email))
            $params['email'] = $user->email;
        if (!is_null($user->phone))
            $params['phone'] = $user->phone;
        if (!is_null($user->birthDate))
            $params['birth_date'] = $user->birthDate == '' ? null : $user->birthDate;

        if (count($params) > 0) {
            if (!is_null($user->id)) {
                return $this->updateWithDuplication($user->id, DB_TABLE_USERS, $params);
            }
            else {
                return $this->create(DB_TABLE_USERS, $params);
            }
        }
    }

    /**
     * Gets user by login
     *
     * @param string $login Login
     * @return User|null User entity or null
     * @throws \db\DatabaseException
     */
    public function getUserByLogin($login) {
        $array = $this->db->getRow('select * from ' . DB_TABLE_USERS_VIEW . ' where login = ?', [$login]);

        if (!is_null($array)) {
            $entity = new User();
            $entity->populate($array);

            return $entity;
        }

        return null;
    }

    /**
     * Deletes user
     *
     * @param User $user User entity
     * @return int Number of affected rows
     */
    public function delete(User $user) {
        return $this->deleteBase($user->id, DB_TABLE_USERS);
    }
}