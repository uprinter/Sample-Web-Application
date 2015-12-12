<?php
use controllers\ControllerException;
use controllers\ErrorsController;
use exceptions\CoreException;

/**
 * Main application class
 */
class App {
    /**
     * Runs application
     */
    public static function run() {
        require_once __DIR__ . '/../configs/config.php';

        try {
            if (isset($_GET['q'])) {
                $path = $_GET['q'];
                $path = trim($path, '/\\');
                $parts = explode('/', $path);

                // Controller name
                if ($parts[0] == '') {
                    $controllerName = 'index';
                }
                else {
                    $controllerName = preg_replace('/[^a-z0-9_]/iu', '', $parts[0]);

                    if ($controllerName == '') {
                        throw new ControllerException('Controller name is empty');
                    }
                }

                // Command name
                $commandName = isset($parts[1]) ? preg_replace('/[^a-z0-9_]/iu', '', $parts[1]) : 'index';
                $commandName = $commandName == '' ? 'index' : $commandName;

                $controllerClassName = '\controllers\\' . ucfirst($controllerName) . 'Controller';

                if (class_exists($controllerClassName)) {
                    $controller = new $controllerClassName;

                    $controllerClass = new ReflectionClass($controllerClassName);

                    $commandFound = false;

                    if ($controllerClass->hasMethod($commandName)) {
                        $commandClass = new ReflectionMethod($controllerClassName, $commandName);

                        if ($commandClass->isPublic()) {
                            $commandFound = true;
                            array_shift($parts);
                            array_shift($parts);
                        }
                    }

                    if (!$commandFound) {
                        array_shift($parts);
                        $commandName = 'index';
                    }

                    $controller->setParams($parts);
                    $controller->$commandName();
                }
                else {
                    $controllerException = new ControllerException('Controller not found:' .
                        $controllerName . ' (' . $_SERVER['REQUEST_URI'] . ')');
                    $controllerException->setControllerClassName($controllerName);
                    throw $controllerException;
                }
            }
            else {
                throw new CoreException('Path parameter "q" not found' . ' (' . $_SERVER['REQUEST_URI'] . ')');
            }
        }
        catch (ControllerException $e) {
            (new ErrorsController())->error404();
        }
        catch (CoreException $e) {
            (new ErrorsController())->error503();
        }
    }
}