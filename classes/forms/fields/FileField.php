<?php
namespace forms\fields;

/**
 * Class FileField
 *
 * Implements file uploading field
 *
 * @package forms\fields
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class FileField extends AbstractField {
    /**
     * Renders field
     *
     * @return string Rendered field
     */
    public function render() {
        $html = '<div class="label' . ($this->isRequired ? ' required' : '') . '">' . $this->label .
            '</div><input type="file" name="' . addslashes($this->name) . '"/>';

        if (!$this->isValid) {
            $html .= '<div class="error">' . $this->error . '</div>';
        }

        return $html;
    }
}