<?php
namespace models;

use entities\File;
use dao\DaoFactory;
use utils\PasswordManager;
use authorization\Authorization;

/**
 * Class FilesModel
 *
 * Implements model operations for files
 *
 * @package models
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class FilesModel extends AbstractModel {
    /**
     * @var \dao\FileDao $dao Instance of DAO
     */
    private $dao;

    /**
     * @var \authorization\Authorization $auth Authorization class instance
     */
    private $auth;

    /**
     * Public constructor
     */
    public function __construct() {
        $this->dao = DaoFactory::getFileDao();
        $this->auth = Authorization::getInstance(SESSION_NAME_DEFAULT, COOKIE_DOMAIN);
    }

    /**
     * Creates file
     *
     * @param array $uploadedFile Array representation of uploaded file
     * @param int $userId User ID
     * @throws ModelException
     */
    public function create(array $uploadedFile, $userId) {
        if (!$this->canAddFiles($userId)) {
            throw new ModelException('You can\'t add more files');
        }

        switch ($uploadedFile['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new ModelException('The uploaded file exceeds the maximum file size');
            case UPLOAD_ERR_PARTIAL:
                throw new ModelException('The uploaded file was only partially uploaded');
            case UPLOAD_ERR_NO_FILE:
                throw new ModelException('No file was uploaded');
            case UPLOAD_ERR_NO_TMP_DIR:
                throw new ModelException('Missing a temporary folder');
            case UPLOAD_ERR_CANT_WRITE:
                throw new ModelException('Failed to write file to disk');
        }

        if (is_uploaded_file($uploadedFile['tmp_name'])) {
            $file = new File();

            // Generate file hash
            $passwordManager = new PasswordManager();
            $hash = $passwordManager->getRandomPassword(50);
            $file->hash = $hash;

            if (!move_uploaded_file($uploadedFile['tmp_name'], UPLOADED_FILES . $file->hash)) {
                throw new ModelException('Uploaded file can\'t be saved');
            }

            // Set user ID
            $file->userId = $userId;

            // Set file size
            $file->size = $uploadedFile['size'];

            // Set original name
            $file->origName = $uploadedFile['name'];

            $this->dao->save($file);
        }
    }

    /**
     * Gets list of files
     *
     * @param int $userId User ID
     * @return array List of files
     */
    public function getList($userId) {
        return $this->dao->getList($userId);
    }

    /**
     * Sends file to user
     *
     * @param string $hash File hash
     * @param int $userId User ID
     * @throws ModelException
     */
    public function sendFile($hash, $userId) {
        $path = UPLOADED_FILES . $hash;

        $file = $this->dao->get($hash);

        if ($file->userId != $userId) {
            throw new ModelException('File unavailable');
        }

        if (file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file->origName . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            ob_clean();
            flush();
            readfile($path);
            exit;
        }
    }

    /**
     * Removes file
     *
     * @param string $hash File hash
     * @param int $userId User ID
     * @throws ModelException
     */
    public function removeFile($hash, $userId) {
        $path = UPLOADED_FILES . $hash;

        $file = $this->dao->get($hash);

        if ($file->userId != $userId) {
            throw new ModelException('File unavailable');
        }

        if (file_exists($path)) {
            if (!unlink($path)) {
                throw new ModelException('Can\'t remove file');
            }
        }

        $this->dao->delete($file);
    }

    /**
     * Determines can user add more files or not
     *
     * @param int $userId User ID
     * @return bool Can user add more files or not
     */
    public function canAddFiles($userId) {
        $files = $this->getList($userId);
        return count($files) < MAX_FILES_NUMBER_PER_USER;
    }
}