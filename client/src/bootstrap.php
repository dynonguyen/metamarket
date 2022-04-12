<!-- Embed config files to load web pages -->
<?php
define('_DIR_ROOT', __DIR__);

// Load config
$config_files = scandir('configs');
if (!empty($config_files)) {
    foreach ($config_files as $file) {
        if ($file !== '.' && $file !== '..' && file_exists('configs/' . $file)) {
            require_once 'configs/' . $file;
        }
    }
}

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(_DIR_ROOT);
$dotenv->safeLoad();

// Load App
require_once 'app/App.php';

// Load Core Class
require_once 'core/Controller.php';
require_once 'core/Route.php';

// Load utils
require_once 'utils/constants.php';
require_once 'utils/ApiCaller.php';
