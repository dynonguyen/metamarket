<?php
$routes['default_controller'] = 'home';

// Virtual route -> real route
$routes['trang-chu'] = 'home';
$routes['nhom-danh-muc/*'] = 'catalog/$1';
$routes['danh-muc/*'] = 'category/$1';
$routes['tai-khoan'] = 'account';
$routes['tai-khoan/dang-ky'] = 'account/signup';
