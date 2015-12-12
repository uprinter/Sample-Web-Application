<?php
namespace authorization;

/**
 * Class AuthorizationException
 *
 * Provides special type of exception for authorization issues
 *
 * @package authorization
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class AuthorizationException extends \Exception {
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