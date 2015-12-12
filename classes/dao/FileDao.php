<?php
namespace dao;

use entities\File;

/**
 * Class FileDao
 *
 * Implements data access operations for files
 *
 * @package dao
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class FileDao extends DaoBase {
    /**
     * Gets file by ID of hash
     *
     * @param int|string $idOrHash File ID or hash
     * @return File|null File entity or null
     * @throws \db\DatabaseException
     */
    public function get($idOrHash) {
        $array = $this->db->getRow('select * from ' . DB_TABLE_FILES_VIEW .
            ' where id = ? or hash = ?', [$idOrHash, $idOrHash]);

        if (!is_null($array)) {
            $entity = new File();
            $entity->populate($array);

            return $entity;
        }

        return null;
    }

    /**
     * Gets list of user's files
     *
     * @param int $userId User ID
     * @return array Array of files
     * @throws \db\DatabaseException
     */
    public function getList($userId) {
        $files = [];
        $array = $this->db->getAll('select * from ' . DB_TABLE_FILES_VIEW . ' where user_id = ?', 'id', [$userId]);

        foreach ($array as $id => $row) {
            $entity = new File();
            $entity->populate($row);
            $files[] = $entity;
        }

        return $files;
    }

    /**
     * Saves user's file
     *
     * @param File $file File entity
     * @return int New file ID or number of affected rows
     * @throws \db\DatabaseException
     */
    public function save(File $file) {
        $params = [];

        if (!is_null($file->id))
            $params['id'] = $file->id;
        if (!is_null($file->userId))
            $params['user_id'] = $file->userId;
        if (!is_null($file->origName))
            $params['orig_name'] = $file->origName;
        if (!is_null($file->hash))
            $params['hash'] = $file->hash;
        if (!is_null($file->size))
            $params['size'] = $file->size;

        if (count($params) > 0) {
            if (!is_null($file->id)) {
                return $this->updateWithDuplication($file->id, DB_TABLE_FILES, $params);
            }
            else {
                return $this->create(DB_TABLE_FILES, $params);
            }
        }
    }

    /**
     * Deletes user's file
     *
     * @param File $file File entity
     * @return int Number of affected rows
     */
    public function delete(File $file) {
        return $this->deleteBase($file->id, DB_TABLE_FILES);
    }
}