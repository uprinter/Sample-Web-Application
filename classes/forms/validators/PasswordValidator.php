<?php
namespace forms\validators;

/**
 * Class PasswordValidator
 *
 * Implements password validation
 *
 * @package forms\validators
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class PasswordValidator implements IValidator {
    /**
     * Check whether field value is valid for this validator or not
     *
     * @return bool Validation status
     */
    public function isValid() {
        $args = func_get_args();
        return preg_match('/^[a-zA-Z0-9\-_~!@#\$%\^&\*\(\)\+]{5,20}$/', $args[0]);
    }

    /**
     * Gets error message for validator
     *
     * @return string Error message
     */
    public function getError() {
        return 'Password should be not less 5 and not greater that 20 symbols and contain only the following symbols: ' .
            'a-z, A-Z, 0-9, -, _, ~, !, @, #, $, %, ^, &, *, (, ), +';
    }
}