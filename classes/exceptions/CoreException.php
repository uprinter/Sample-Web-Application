<?php
namespace exceptions;

/**
 * Class CoreException
 *
 * Provides special type of exception for application
 *
 * @package exceptions
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class CoreException extends \Exception {
    /**
     * Public constructor
     *
     * @param string $message Exception message
     * @param int $code Exception code
     */
    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }
}