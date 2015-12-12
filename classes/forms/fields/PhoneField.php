<?php
namespace forms\fields;

/**
 * Class PhoneField
 *
 * Implements phone field
 *
 * @package forms\fields
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class PhoneField extends AbstractField {
    /**
     * Renders field
     *
     * @return string Rendered field
     */
    public function render() {
        $html = '<div class="label' . ($this->isRequired ? ' required' : '') . '">' . $this->label .
            '</div><input type="tel" name="' . addslashes($this->name) .
            '" value="' . addslashes($this->value) . '"/>';

        if (!$this->isValid) {
            $html .= '<div class="error">' . $this->error . '</div>';
        }

        return $html;
    }
}