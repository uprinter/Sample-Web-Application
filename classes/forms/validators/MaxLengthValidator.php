<?php
namespace forms\validators;

/**
 * Class MaxLengthValidator
 *
 * Implements max value length validation
 *
 * @package forms\validators
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class MaxLengthValidator implements IValidator {
    /**
     * @var int $maxLength Max field value length
     */
    private $maxLength;

    /**
     * Public constructor
     *
     * @param int $maxLength Max field value length
     */
    public function __construct($maxLength) {
        $this->maxLength = $maxLength;
    }

    /**
     * Check whether field value is valid for this validator or not
     *
     * @return bool Validation status
     */
    public function isValid() {
        $args = func_get_args();
        return strlen(trim($args[0])) <= $this->maxLength;
    }

    /**
     * Gets error message for validator
     *
     * @return string Error message
     */
    public function getError() {
        return 'Max length should be ' . $this->maxLength;
    }
}