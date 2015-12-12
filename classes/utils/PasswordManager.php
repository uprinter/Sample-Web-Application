<?php
namespace utils;

/**
 * Class PasswordManager
 *
 * Provides functionality for managing passwords
 *
 * @package utils
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class PasswordManager {
    /**
     * Gets random password
     *
     * @param int $length Password length
     * @return string Generated password
     */
    public function getRandomPassword($length = 10) {
        $hash = '';

        for ($i = 0; $i < $length; $i++) {
            $rand1 = rand(65, 90);
            $rand2 = rand(97, 122);
            $array = [$rand1, $rand2];
            $rand = array_rand($array, 1);
            $hash .= chr($array[$rand]);
        }

        return $hash;
    }

    /**
     * Gets random salt
     *
     * @param int $length Salt length
     * @return string Generated salt
     */
    public function getRandomSalt($length = 3) {
        $salt = '';

        for ($i = 0; $i < $length; $i++) {
            $rand = rand(33, 126);
            $salt .= chr($rand);
        }

        return $salt;
    }

    /**
     * Gets password hash
     *
     * @param string $password Password
     * @param string $salt Salt
     * @return string Hash
     */
    public function getHash($password, $salt) {
        return md5(md5($password) . $salt);
    }

    /**
     * Gets hash and salt
     *
     * @param int $passLength Password length
     * @param int $saltLength Salt length
     * @return array Password and salt
     */
    public function getHashAndSalt($passLength = 10, $saltLength = 3) {
        $password = $this->getRandomPassword($passLength);
        $salt = $this->getRandomSalt($saltLength);
        $hash = $this->getHash($password, $salt);
        return ['password' => $hash, 'salt' => $salt];
    }
}