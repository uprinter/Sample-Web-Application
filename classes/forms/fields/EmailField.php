<?php
namespace forms\fields;

/**
 * Class EmailField
 *
 * Implements field for entering e-mail address
 *
 * @package forms\fields
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class EmailField extends AbstractField {
    /**
     * Renders field
     *
     * @return string Rendered field
     */
    public function render() {
        $html = '<div class="label' . ($this->isRequired ? ' required' : '') . '">' .
            $this->label . '</div><input type="email" name="' . addslashes($this->name) .
            '" value="' . addslashes($this->value) . '"/>';

        if (!$this->isValid) {
            $html .= '<div class="error">' . $this->error . '</div>';
        }

        return $html;
    }
}