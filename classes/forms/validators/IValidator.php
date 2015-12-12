<?php
namespace forms\validators;

/**
 * Interface IValidator
 *
 * Provides interface for web form validators
 *
 * @package forms\validators
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
interface IValidator {
    /**
     * Check whether field value is valid for this validator or not
     *
     * @return bool Validation status
     */
    public function isValid();

    /**
     * Gets error message for validator
     *
     * @return string Error message
     */
    public function getError();
}