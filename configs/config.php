<?php
define('UPLOADED_FILES', __DIR__ . '/../uploaded_files/');
define('MAX_UPLOADED_FILE_SIZE', 1048576);
define('MAX_FILES_NUMBER_PER_USER', 20);

define('DB_HOST', 'localhost:3307');
define('DB_USER', 'root');
define('DB_PASSWORD', 'admin');
define('DB_NAME', 'test');

define('DB_TABLE_USERS', DB_NAME . '.users');
define('DB_TABLE_USERS_VIEW', DB_NAME . '.users_view');
define('DB_TABLE_FILES', DB_NAME . '.files');
define('DB_TABLE_FILES_VIEW', DB_NAME . '.files_view');

define('SESSION_NAME_DEFAULT', 's');
define('COOKIE_DOMAIN', false);

date_default_timezone_set('Europe/Moscow');