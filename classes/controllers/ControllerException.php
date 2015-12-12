<?php
namespace controllers;

use exceptions\CoreException;

/**
 * Class ControllerException
 *
 * Provides special type of exception for controller issues
 *
 * @package controllers
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class ControllerException extends CoreException {
    private $controllerClassName;

    /**
     * Public constructor
     *
     * @param string $message Exception message
     * @param int $code Exception code
     */
    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }

    /**
     * Gets controller class name
     *
     * @return string Controller class name
     */
    public function getControllerClassName() {
        return $this->controllerClassName;
    }

    /**
     * Sets controller class name
     *
     * @param string $controllerClassName Controller class name
     */
    public function setControllerClassName($controllerClassName) {
        $this->controllerClassName = $controllerClassName;
    }
}