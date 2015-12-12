<?php
namespace forms\fields;

/**
 * Class PasswordField
 *
 * Implements password field
 *
 * @package forms\fields
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class PasswordField extends AbstractField {
    /**
     * Renders field
     *
     * @return string Rendered field
     */
    public function render() {
        $html = '<div class="label' . ($this->isRequired ? ' required' : '') . '">' .
            $this->label . '</div><input type="password" name="' . addslashes($this->name) .
            '" value="' . addslashes($this->value) . '"/>';

        if (!$this->isValid) {
            $html .= '<div class="error">' . $this->error . '</div>';
        }

        return $html;
    }
}