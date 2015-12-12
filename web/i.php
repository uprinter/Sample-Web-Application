<?php
require_once __DIR__ . '/../classes/ClassLoader.php';

// Register autoload  method
spl_autoload_register([new ClassLoader(), 'loadClass']);

App::run();