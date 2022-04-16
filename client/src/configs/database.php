<?php
$config['database'] = [
    'host' => $_ENV['USER_SERVICE_DB_HOST'] ?? '127.0.0.1',
    'username' => $_ENV['USER_SERVICE_DB_USERNAME'] ?? 'root',
    'password' =>  $_ENV['USER_SERVICE_DB_PASSWORD'] ?? '',
    'db' => $_ENV['USER_SERVICE_DB_NAME'] ?? 'user_service'
];
