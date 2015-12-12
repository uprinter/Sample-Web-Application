<?php
namespace models;

/**
 * Abstract class AbstractModel
 *
 * Base class for model
 *
 * @package models
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
abstract class AbstractModel {
    /**
     * Converts dates to or from system format
     *
     * @param array $array Array of values
     * @param array $fields Array of fields to convert
     */
    public function convertDates(array &$array, array $fields) {
        foreach ($fields as $field) {
            if (isset($array[$field]) && trim($array[$field]) != '') {
                if (strpos($array[$field], '.')) {
                    list($day, $month, $year) = explode('.', $array[$field]);
                    $array[$field] = $year . '-' . $month . '-' . $day;
                }
                else {
                    list($year, $month, $day) = explode('-', $array[$field]);
                    $array[$field] = $day . '.' . $month . '.' . $year;
                }
            }
        }
    }
}