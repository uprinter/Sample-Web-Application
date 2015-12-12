<?php
namespace renderers;

/**
 * Singleton class Renderer
 *
 * Provides instance of particular template class implementation
 *
 * @package renderers
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class Renderer
{
    /**
     * @var object|null $instance Stores instance of this class
     */
    private static $instance;

    /**
     * Private constructor
     */
    private function __construct() {}

    /**
     * Private clone method (prevent object cloning)
     */
    private function __clone() {}

    /**
     * Gets instance of particular template class implementation
     *
     * @return HtmlRenderer Particular template class implementation
     */
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new HtmlRenderer();
        }

        return self::$instance;
    }
}