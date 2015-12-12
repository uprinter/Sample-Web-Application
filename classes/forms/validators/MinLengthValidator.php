<?php
namespace forms\validators;

/**
 * Class MinLengthValidator
 *
 * Implements min value length validation
 *
 * @package forms\validators
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class MinLengthValidator implements IValidator {
    /**
     * @var int $maxLength Min field value length
     */
    private $minLength;

    /**
     * Public constructor
     *
     * @param $minLength Min field value length
     */
    public function __construct($minLength) {
        $this->minLength = $minLength;
    }

    /**
     * Check whether field value is valid for this validator or not
     *
     * @return bool Validation status
     */
    public function isValid() {
        $args = func_get_args();
        return strlen(trim($args[0])) >= $this->minLength;
    }

    /**
     * Gets error message for validator
     *
     * @return string Error message
     */
    public function getError() {
        return 'Min length should be at lease ' . $this->minLength;
    }
}