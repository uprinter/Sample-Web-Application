<?php
/**
 * Class ClassLoader
 *
 * Implementation of class auto loading
 *
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class ClassLoader {
    /**
     * Loads class
     *
     * @param string $class Class name
     */
    public function loadClass($class) {
        $fileName = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

        if (file_exists($fileName)) {
            require_once $fileName;
        }
    }
}