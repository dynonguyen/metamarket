<?php

// Services URL
define('AGGREGATE_SERVICE_API_URL', $_ENV['AGGREGATE_SERVICE_API'] ?? '');
define('INTERNAL_SERVICE_API_URL', $_ENV['INTERNAL_SERVICE_API'] ?? '');
define('ORDER_SERVICE_API_URL', $_ENV['ORDER_SERVICE_API'] ?? '');
define('PAYMENT_SERVICE_API_URL', $_ENV['PAYMENT_SERVICE_API'] ?? '');
define('PRODUCT_SERVICE_API_URL', $_ENV['PRODUCT_SERVICE_API'] ?? '');
define('REVIEW_SERVICE_API_URL', $_ENV['REVIEW_SERVICE_API'] ?? '');
define('SHIPPING_SERVICE_API_URL', $_ENV['SHIPPING_SERVICE_API'] ?? '');
define('SHOP_SERVICE_API_URL', $_ENV['SHOP_SERVICE_API'] ?? '');
define('SUPPORT_SERVICE_API_URL', $_ENV['SUPPORT_SERVICE_API'] ?? '');
define('USER_SERVICE_API_URL', $_ENV['USER_SERVICE_API'] ?? '');

define('DEFAULT_PRODUCT_AVT', 'https://res.cloudinary.com/dynonary/image/upload/v1650187901/metamarket/product-not-found.png');

// min max
define('MAX_LEN_EMAIL', 150);
define('MAX_LEN_FULLNAME', 50);
define('MAX_LEN_PASSWORD', 50);
define('BCRYPT_SALT', 10);
