<?php
namespace forms\validators;

use forms\fields\IField;

/**
 * Class EqualToValidator
 *
 * Implements comparing with another field
 *
 * @package forms\validators
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class EqualToValidator implements IValidator
{
    /**
     * @var IField $equalToField Field to compare values
     */
    private $equalToField;

    /**
     * Public constructor
     *
     * @param IField $equalToField Field to compare values
     */
    public function __construct(IField $equalToField) {
        $this->equalToField = $equalToField;
    }

    /**
     * Check whether field value is valid for this validator or not
     *
     * @return bool Validation status
     */
    public function isValid() {
        $args = func_get_args();
        return $args[0] == $this->equalToField->getValue();
    }

    /**
     * Gets error message for validator
     *
     * @return string Error message
     */
    public function getError() {
        return 'Value should be equal to the value of "' . $this->equalToField->getLabel() . '" field';
    }
}