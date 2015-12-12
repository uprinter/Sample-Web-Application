<?php
namespace entities;

/**
 * Class File
 *
 * Plain class for mapping to database table structure
 *
 * @package entities
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class File extends Object {
    /**
     * @var string $origName Original file name
     */
    private $origName;

    /**
     * @var string $userId User ID
     */
    private $userId;

    /**
     * @var string $hash File hash
     */
    private $hash;

    /**
     * @var string $size File size
     */
    private $size;

    /**
     * Getter for original name field
     *
     * @return string Original name
     */
    public function getOrigName()
    {
        return $this->origName;
    }

    /**
     * Setter for original name field
     *
     * @param string $origName Original name
     */
    public function setOrigName($origName)
    {
        $this->origName = $origName;
    }

    /**
     * Getter for hash field
     *
     * @return string Hash field
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Setter for hash field
     *
     * @param string $hash Hash field
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * Getter for user ID field
     *
     * @return string User ID
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Setter for user ID field
     *
     * @param string $userId User ID
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Getter for file size field
     *
     * @return string File size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Setter for file size field
     *
     * @param string $size File size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
}