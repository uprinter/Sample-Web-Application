<?php
namespace forms\validators;

/**
 * Class EmailValidator
 *
 * Implements e-mail validation
 *
 * @package forms\validators
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class EmailValidator implements IValidator {
    /**
     * Check whether field value is valid for this validator or not
     *
     * @return bool Validation status
     */
    public function isValid() {
        $args = func_get_args();
        $email = trim($args[0]);
        return $email == '' || filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Gets error message for validator
     *
     * @return string Error message
     */
    public function getError() {
        return 'Incorrect e-mail address';
    }
}