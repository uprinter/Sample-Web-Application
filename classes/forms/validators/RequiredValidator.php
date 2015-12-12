<?php
namespace forms\validators;

/**
 * Class RequiredValidator
 *
 * Implements required field validation
 *
 * @package forms\validators
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class RequiredValidator implements IValidator {
    /**
     * Check whether field value is valid for this validator or not
     *
     * @return bool Validation status
     */
    public function isValid() {
        $args = func_get_args();
        return trim($args[0]) != '';
    }

    /**
     * Gets error message for validator
     *
     * @return string Error message
     */
    public function getError() {
        return 'Field is required';
    }
}