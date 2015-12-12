<?php
namespace controllers;

/**
 * Class ErrorsController
 *
 * Controller for handling issues
 *
 * @package controllers
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class ErrorsController extends BaseController {
    /**
     * Default controller command
     */
    public function index() {}

    /**
     * Generates error 404
     */
    public function error404() {
        header('HTTP/1.0 404 Not Found');
        echo 'Page not found';
        exit;
    }

    /**
     * Generate error 503
     */
    public function error503() {
        header('HTTP/1.0 503 Service Unavailable');
        echo 'Service Unavailable';
        exit;
    }
}