<?php
namespace dao;

use db\Database;
use db\DatabaseException;

/**
 * Class DaoBase
 *
 * Supports update/remove operations in database base with storing changes
 *
 * @package dao
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class DaoBase {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance(DB_HOST, DB_USER, DB_PASSWORD);
    }

    public function updateWithDuplication($id, $table, $params) {
        try {
            $this->db->beginTransaction();

            // Backup current row
            $oldRow = $this->db->getRow('select * from ' . $table . ' where id = ? and current = ?', [$id, 1]);
            $oldRowId = $oldRow['system_id'];

            unset($oldRow['system_id']);
            unset($oldRow['current']);

            $this->db->update('update ' . $table . ' set current = ? where system_id = ?', [null, $oldRowId]);

            $columns = array_merge(['system_id', 'current'], array_keys($oldRow));
            $values = array_merge([null, 1], array_values($oldRow));
            $valuesSubst =  str_repeat('?, ', count($values) - 1) . '?';

            $this->db->insert('insert into ' . $table . ' (' . implode(', ', $columns) . ') values (' . $valuesSubst . ')',
                $values);

            // Update new row
            $columns = array_keys($params);
            $values = array_values($params);
            $columnsSubst = implode('=?, ', $columns) . '=?';

            $affectedRowsNum = $this->db->update('update ' . $table . ' set ' . $columnsSubst .
                ' where id = ? and current = ?', array_merge($values, [$id, 1]));

            $this->db->commit();

            return $affectedRowsNum;
        }
        catch (DatabaseException $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function create($table, $params) {
        try {
            $this->db->beginTransaction();

            $columns = array_merge(['current'], array_keys($params));
            $values = array_merge([1], array_values($params));
            $valuesSubst =  str_repeat('?, ', count($values) - 1) . '?';

            $lastInsertId = $this->db->insert('insert into ' . $table .
                ' (' . implode(', ', $columns) . ') values (' . $valuesSubst . ')', $values);

            $this->db->update('update ' . $table . ' set id = system_id
                where system_id = ? and current = ?', [$lastInsertId, 1]);

            $this->db->commit();

            return $lastInsertId;
        }
        catch (DatabaseException $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function deleteBase($id, $table) {
        return $this->db->update('update ' . $table . ' set current = ?
            where id = ? and current = ?', [null, $id, 1]);
    }
}