<?php
namespace db;

/**
 * Interface IDatabase
 *
 * Provides interface for database access class implementations
 *
 * @package db
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
interface IDatabase {
    /**
     * Gets scalar
     *
     * @param string $query Database query
     * @param array $params Extra params
     * @return null|string
     */
    public function getOne($query, array $params = []);

    /**
     * Gets one row
     *
     * @param string $query Database query
     * @param array $params Extra params
     * @return null|array
     */
    public function getRow($query, array $params = []);

    /**
     * Gets all rows
     *
     * @param string $query Database query
     * @param string $indexCol Name of index column
     * @param array $params Extra params
     * @return array
     */
    public function getAll($query, $indexCol = 'id', array $params = []);

    /**
     * Gets values of one column
     *
     * @param string $query Database query
     * @param array $params Extra params
     * @return array
     */
    public function getCol($query, array $params = []);

    /**
     * Executes query
     *
     * @param string $query Database query
     * @param array $params Extra params
     * @return mixed Result of execution
     */
    public function exec($query, array $params = []);

    /**
     * Inserts new row
     *
     * @param string $query Database query
     * @param array $params Extra params
     * @return int Inserted row ID
     */
    public function insert($query, array $params = []);

    /**
     * Updates existing row
     *
     * @param string $query Database query
     * @param array $params Extra params
     * @return int Number of affected rows
     */
    public function update($query, array $params = []);

    /**
     * Deletes existing row
     *
     * @param string $query Database query
     * @param array $params Extra params
     * @return int Number of affected rows
     */
    public function delete($query, array $params = []);

    /**
     * Begins database transaction
     */
    public function beginTransaction();

    /**
     * Commits database transaction
     */
    public function commit();

    /**
     * Rollbacks database transaction
     */
    public function rollback();
}