<?php
require_once _DIR_ROOT . '/app/models/User.php';
require_once _DIR_ROOT . '/app/models/Shop.php';
require_once _DIR_ROOT . '/app/models/AdminAccount.php';

$user = new UserModel();
$shop = new ShopModel();
$adminAccount = new AdminAccountModel();
$isAuth = false;
$hostUrl = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, strpos($_SERVER["SERVER_PROTOCOL"], '/'))) . '://' . $_SERVER['HTTP_HOST'];
