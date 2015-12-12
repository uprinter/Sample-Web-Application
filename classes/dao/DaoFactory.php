<?php
namespace dao;

/**
 * Class DaoFactory
 *
 * Factory for DAO classes
 *
 * @package dao
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class DaoFactory {
    /**
     * Gets DAO for users
     *
     * @return UserDao Users DAO
     */
    public static function getUserDao() {
        return new UserDao();
    }

    /**
     * Gets DAO for files
     *
     * @return FileDao Files DAO
     */
    public static function getFileDao() {
        return new FileDao();
    }
}