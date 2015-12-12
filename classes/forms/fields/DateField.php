<?php
namespace forms\fields;

/**
 * Class DateField
 *
 * Implements date selection field
 *
 * @package forms\fields
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class DateField extends AbstractField {
    /**
     * Renders field
     *
     * @return string Rendered field
     */
    public function render() {
        $html = '<div class="label' . ($this->isRequired ? ' required' : '') . '">' .
            $this->label . '</div><input type="text" name="' . addslashes($this->name) .
            '" placeholder="dd.mm.yyyy" value="' . addslashes($this->value) . '"/>';

        if (!$this->isValid) {
            $html .= '<div class="error">' . $this->error . '</div>';
        }

        return $html;
    }
}