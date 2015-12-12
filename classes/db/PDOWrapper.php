<?php
namespace db;

/**
 * Class PDOWrapper
 *
 * Implements database access operation for PDO
 *
 * @package db
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class PDOWrapper implements IDatabase {
    /**
     * @var null|\PDO $link Current connection link
     */
    private $link = null;

    /**
     * @var string $charset Connection charset
     */
    private $charset = 'utf8';

    /**
     * Public constructor
     *
     * @throws DatabaseException
     */
    public function __construct() {
        try {
            $this->link = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER,
                DB_PASSWORD, [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'' . $this->charset . '\'']);
            $this->link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
    }

    public function getOne($query, array $params = [])
    {
        try {
            $pdoStatement = $this->link->prepare($query);
            $pdoStatement->execute($params);
            $result = $pdoStatement->fetchAll();
            return !empty($result) ? $result[0][0] : null;
        }
        catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), 0, $query);
        }
    }

    public function getRow($query, array $params = [])
    {
        try {
            $pdoStatement = $this->link->prepare($query);
            $pdoStatement->execute($params);
            $result = $pdoStatement->fetch(\PDO::FETCH_ASSOC);
            return !empty($result) ? $result : null;
        }
        catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), 0, $query);
        }
    }

    public function getAll($query, $indexCol = 'id', array $params = [])
    {
        try {
            $pdoStatement = $this->link->prepare($query);
            $pdoStatement->execute($params);

            $result = [];

            while ($row = $pdoStatement->fetch(\PDO::FETCH_ASSOC)) {
                if (isset($row[$indexCol])) {
                    $result[$row[$indexCol]] = $row;
                }
                else {
                    $result[] = $row;
                }
            }

            return $result;
        }
        catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), 0, $query);
        }
    }

    public function getCol($query, array $params = [])
    {
        try {
            $pdoStatement = $this->link->prepare($query);
            $pdoStatement->execute($params);

            $result = [];

            while ($value = $pdoStatement->fetchColumn()) {
                $result[] = $value;
            }
            return $result;
        }
        catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), 0, $query);
        }
    }

    public function exec($query, array $params = [])
    {
        try {
            return $this->link->exec($query);
        }
        catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), 0, $query);
        }
    }

    public function insert($query, array $params = [])
    {
        try {
            $pdoStatement = $this->link->prepare($query);
            $pdoStatement->execute($params);
            return $this->link->lastInsertId();
        }
        catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), 0, $query);
        }
    }

    public function update($query, array $params = [])
    {
        try {
            $pdoStatement = $this->link->prepare($query);
            $pdoStatement->execute($params);
            return $pdoStatement->rowCount();
        }
        catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), 0, $query);
        }
    }

    public function delete($query, array $params = [])
    {
        try {
            $pdoStatement = $this->link->prepare($query);
            $pdoStatement->execute($params);
            return $pdoStatement->rowCount();
        }
        catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage(), 0, $query);
        }
    }

    public function beginTransaction()
    {
        $this->link->beginTransaction();
    }

    public function commit()
    {
        $this->link->commit();
    }

    public function rollback()
    {
        $this->link->rollBack();
    }
}