<?php
namespace forms\fields;

/**
 * Interface IField
 *
 * Provides interface for web form fields
 *
 * @package forms\fields
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
interface IField {
    /**
     * Renders field
     */
    public function render();

    /**
     * Sets field value
     *
     * @param string $value Value
     */
    public function setValue($value);

    /**
     * Gets field value
     *
     * @return string Value
     */
    public function getValue();

    /**
     * Validates field
     */
    public function validate();

    /**
     * Check whether field valid or not
     *
     * @return bool Validation status
     */
    public function isValid();

    /**
     * Gets field name
     *
     * @return string Field name
     */
    public function getName();

    /**
     * Sets error message
     *
     * @param string $error Error message
     */
    public function setError($error);
}