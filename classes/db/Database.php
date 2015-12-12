<?php
namespace db;

/**
 * Singleton class Database
 *
 * Provides instance of particular database access class implementation
 *
 * @package db
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class Database {
    /**
     * @var object|null $instance Stores instance of this class
     */
    private static $instance;

    /**
     * Private constructor
     */
    private function __construct() {}

    /**
     * Private clone method (prevent object cloning)
     */
    private function __clone() {}

    /**
     * Gets instance of particular database access class implementation
     *
     * @return PDOWrapper Particular database access class implementation
     */
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new PDOWrapper();
        }

        return self::$instance;
    }
}