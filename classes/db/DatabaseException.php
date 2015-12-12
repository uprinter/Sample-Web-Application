<?php
namespace db;

/**
 * Class DatabaseException
 *
 * Provides special type of exception for database issues
 *
 * @package db
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class DatabaseException extends \Exception {
    private $query = '';

    /**
     * Public constructor
     *
     * @param string $message Exception message
     * @param int $code Exception code
     * @param string $query Database query
     */
    public function __construct($message, $code = 0, $query = '') {
        parent::__construct($message, $code);
        $this->query = $query;
    }

    /**
     * Gets database query
     *
     * @return string
     */
    public function getQuery() {
        return $this->query;
    }
}