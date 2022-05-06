<?php
require_once _DIR_ROOT . '/app/models/User.php';
require_once _DIR_ROOT . '/app/models/Shop.php';

$user = new UserModel();
$shop = new ShopModel();
$isAuth = false;
