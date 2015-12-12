<?php
namespace forms;

use forms\fields\IField;

/**
 * Class Form
 *
 * Provides functionality for working with web forms
 *
 * @package forms
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class Form {
    /**
     * @var array $fields Array of form fields
     */
    private $fields;

    /**
     * @var bool $isValid Is form valid or not
     */
    private $isValid;

    /**
     * Adds field into form
     *
     * @param IField $field Field
     * @return object This class instance
     */
    public function addField(IField $field) {
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    /**
     * Gets field by name
     *
     * @param string $name Field name
     * @return null|object Form field or null
     */
    public function getField($name) {
        if (isset($this->fields[$name])) {
            return $this->fields[$name];
        }
        return null;
    }

    /**
     * Populates form fields by values from array
     *
     * @param array $values Values
     */
    public function populate(array $values) {
        foreach ($values as $key => $value) {
            if (isset($this->fields[$key])) {
                $this->fields[$key]->setValue($value);
            }
        }
    }

    /**
     * Renders form
     *
     * @return string Rendered form
     */
    public function render() {
        $string = '';

        foreach ($this->fields as $field) {
            $string .= '<div>' . $field->render() . '</div>';
        }

        return $string;
    }

    /**
     * Validates form
     *
     * @return object This class instance
     */
    public function validate() {
        $this->isValid = true;

        foreach ($this->fields as $field) {
            $field->validate();
            $this->isValid =  $this->isValid && $field->isValid();
        }

        return $this;
    }

    /**
     * Check whether form valid or not
     *
     * @return bool Validation status
     */
    public function isValid() {
        return $this->isValid;
    }
}