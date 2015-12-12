<?php
namespace forms\fields;

/**
 * Class SubmitField
 *
 * Implements submit field
 *
 * @package forms\fields
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class SubmitField extends AbstractField {
    /**
     * Public constructor
     *
     * @param string $label Label
     */
    public function __construct($label) {
        parent::__construct('', $label);
    }

    /**
     * Renders field
     *
     * @return string Rendered field
     */
    public function render() {
        return '<input type="submit" value="' . addslashes($this->label) . '"/>';
    }
}