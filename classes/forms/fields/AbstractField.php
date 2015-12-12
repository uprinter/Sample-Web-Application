<?php
namespace forms\fields;

use forms\validators\IValidator;

/**
 * Abstract class AbstractField
 *
 * Provides base implementation of web form field
 *
 * @package forms\fields
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
abstract class AbstractField implements IField {
    /**
     * @var string $name Field name
     */
    protected $name;

    /**
     * @var string $label Field label
     */
    protected $label;

    /**
     * @var string $value Field value
     */
    protected $value;

    /**
     * @var array $validators Field validators
     */
    protected $validators = [];

    /**
     * @var bool $isValid Is field valid or not
     */
    protected $isValid = true;

    /**
     * @var string $error Error message
     */
    protected $error = '';

    /**
     * @var bool $isRequired Is field required or not
     */
    protected $isRequired = false;

    /**
     * Public constructor
     *
     * @param string $name Field name
     * @param string $label Field label
     */
    public function __construct($name, $label = '') {
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * Adds validator for field
     *
     * @param IValidator $validator Validator
     * @return object This class instance
     */
    public function addValidator(IValidator $validator) {
        $this->validators[] = $validator;

        if (get_class($validator) == 'forms\validators\RequiredValidator') {
            $this->isRequired = true;
        }

        return $this;
    }

    /**
     * Getter for name field
     *
     * @return string Field name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Getter for label field
     *
     * @return string Label
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * Setter for field value
     *
     * @param string $value Value
     */
    public function setValue($value) {
        $this->value = trim($value);
    }

    /**
     * Getter for field value
     *
     * @return string Value
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Setter for error field
     *
     * @param string $error Error message
     */
    public function setError($error) {
        $this->error = $error;
        $this->isValid = false;
    }

    /**
     * Validates field
     *
     * @return object This class instance
     */
    public function validate() {
        $this->isValid = true;

        foreach ($this->validators as $validator) {
            if (!$validator->isValid($this->value)) {
                $this->isValid = false;
                $this->error = $validator->getError();
                break;
            }
        }

        return $this;
    }

    /**
     * Check whether field valid or not
     *
     * @return bool Validation status
     */
    public function isValid() {
        return $this->isValid;
    }

    /**
     * Renders field
     *
     * @return string Rendered field
     */
    public function render() {
        $html = '<div class="label' . ($this->isRequired ? ' required' : '') . '">' .
            $this->label . '</div><input type="text" name="' .
            addslashes($this->name) . '" value="' . addslashes($this->value) . '"/>';

        if (!$this->isValid) {
            $html .= '<div class="error">' . $this->error . '</div>';
        }

        return $html;
    }
}