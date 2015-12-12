<?php
namespace entities;

/**
 * Class User
 *
 * Plain class for mapping to database table structure
 *
 * @package entities
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class User extends Object {
    /**
     * @var string $login Login
     */
    private $login;

    /**
     * @var string $firstName First name
     */
    private $firstName;

    /**
     * @var string $lastName Last name
     */
    private $lastName;

    /**
     * @var string $email E-mail
     */
    private $email;

    /**
     * @var string $password Password
     */
    private $password;

    /**
     * @var string $salt Salt
     */
    private $salt;

    /**
     * @var string $phone Phone
     */
    private $phone;

    /**
     * @var string $birthDate Birth date
     */
    private $birthDate;

    /**
     * Setter for login field
     *
     * @param string $login Login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Getter for login field
     *
     * @return string Login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Getter for first name field
     *
     * @return string First name
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * Setter for first name field
     *
     * @param string $name First name
     */
    public function setFirstName($name) {
        $this->firstName = $name;
    }

    /**
     * Getter for last name field
     *
     * @return string Last name
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * Setter for last name field
     *
     * @param string $lastName Last name
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * Getter for e-mail field
     *
     * @return string E-mail
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Setter for e-mail field
     *
     * @param string $email E-mail
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Getter for password field
     *
     * @return string Password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Setter for password field
     *
     * @param string $password Password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Getter for salt field
     *
     * @return string Salt
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * Setter for salt field
     *
     * @param string $salt Salt
     */
    public function setSalt($salt) {
        $this->salt = $salt;
    }

    /**
     * Setter for phone field
     *
     * @param string $phone Phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Getter for phone field
     *
     * @return string Phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Setter for birth date field
     *
     * @param string $birthDate Birth date
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * Getter for birth date field
     *
     * @return string Birth date
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }
}