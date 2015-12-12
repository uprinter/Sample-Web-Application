<?php
namespace forms\validators;

/**
 * Class DateValidator
 *
 * Implements date validation
 *
 * @package forms\validators
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class DateValidator implements IValidator {
    /**
     * Check whether field value is valid for this validator or not
     *
     * @return bool Validation status
     */
    public function isValid() {
        $args = func_get_args();

        if (trim($args[0]) == '') return true;

        if (preg_match('/^([0-9]{2})\.([0-9]{2})\.([0-9]{4})$/', $args[0], $matches)) {
            $day = (int) ($matches[1][0] == '0' ? $matches[1][1] : $matches[1]);
            $month = (int) ($matches[2][0] == '0' ? $matches[2][1] : $matches[2]);
            $year = (int) $matches[3];
            $date = $year . '-' . $month . '-' . $day;

            if (strtotime($date)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets error message for validator
     *
     * @return string Error message
     */
    public function getError() {
        return 'Incorrect date format';
    }
}