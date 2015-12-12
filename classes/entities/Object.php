<?php
namespace entities;

/**
 * Class Object
 *
 * Base plain class for mapping to database table structure
 *
 * @package entities
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class Object {
    /**
     * @var int Object ID
     */
    private $id;

    /**
     * Magic method for getting properties
     *
     * @param string $name Property name
     * @return mixed
     */
    public function __get($name) {
        $methodName = 'get' . ucfirst($name);

        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }
    }

    /**
     * Magic method for setting properties
     *
     * @param string $name Property name
     * @param mixed $value Property value
     */
    public function __set($name, $value) {
        $methodName = 'set' . ucfirst($name);

        if (method_exists($this, $methodName)) {
            $this->$methodName($value);
        }
    }

    /**
     * Gets object ID
     *
     * @return int Object ID
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets object ID
     *
     * @param int $id Object ID
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Populates object by values from array
     *
     * @param array $array Array of values
     */
    public function populate(array $array) {
        foreach ($array as $key => $value) {
            $valueParts = explode('_', $key);

            $methodName = 'set' . implode('', array_map(function($string) {
                return ucfirst(strtolower($string));
            }, $valueParts));

            if (method_exists($this, $methodName)) {
                $this->$methodName(trim($value));
            }
        }
    }
}