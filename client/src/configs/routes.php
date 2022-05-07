<?php
$routes['default_controller'] = 'home';

// Virtual route -> real route
$routes['trang-chu'] = 'home';

$routes['nhom-danh-muc/*'] = 'catalog/$1';
$routes['catalog/(.+)'] = 'catalog/index/$1';
$routes['category/(.+)/(.+)'] = 'catalog/category/$1/$2';
$routes['danh-muc/*'] = 'category/$1';

$routes['tai-khoan'] = 'account/index';
$routes['tai-khoan/dang-ky'] = 'account/signup';
$routes['tai-khoan/dang-nhap'] = 'account/login';
$routes['quen-mat-khau'] = 'account/forgotPassword';
$routes['thay-doi-mat-khau'] = 'account/changePassword';

$routes['san-pham/(.+)'] = 'product/index/$1';
$routes['tim-kiem'] = 'product/search';

$routes['gio-hang'] = 'cart/index';

$routes['kenh-ban-hang/san-pham/them'] = 'shop/addProduct';
$routes['kenh-ban-hang/san-pham/them/post'] = 'shop/postAddProduct';
