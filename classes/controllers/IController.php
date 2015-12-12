<?php
namespace controllers;

/**
 * Interface IController
 *
 * Provides interface for controllers
 *
 * @package controllers
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
interface IController {
    /**
     * Default controller command
     */
    public function index();
}