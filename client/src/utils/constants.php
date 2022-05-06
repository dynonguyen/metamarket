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
define('DEFAULT_SHOP_AVT', 'https://res.cloudinary.com/dynonary/image/upload/v1651848045/metamarket/shop-not-found.png');

// min max
define('MAX_LEN_EMAIL', 150);
define('MAX_LEN_FULLNAME', 50);
define('MAX_LEN_PASSWORD', 50);
define('BCRYPT_SALT', 10);

// Jwt
define('JWT_SECRET_KEY', $_ENV['JWT_SECRET_KEY'] ?? 'secret');
define('JWT_ISSUER', $_ENV['JWT_ISSUER'] ?? 'MetaMarket');
define('JWT_ALG', $_ENV['JWT_ALG'] ?? 'HS265');
define('JWT_EXP', 3 * 86400); // 3 days

// Cookie
define('COOKIE_LOGIN_KEY', 'atk');
define('COOKIE_LOGIN_EXP', time() + 3 * 86400); // 3 days

// Google API
define('GOOGLE_API_ID', $_ENV['GOOGLE_API_ID'] ?? '');
define('GOOGLE_API_SECRET', $_ENV['GOOGLE_API_SECRET'] ?? '');
define('GOOGLE_API_CALLBACK_URL', $_ENV['GOOGLE_API_CALLBACK_URL'] ?? '');

// Role
define('USER_ROLE', 1);
define('SHOP_ROLE', 2);
define('SHIPPER_ROLE', 3);
define('ADMIN_ROLE', 4);
define('GUEST_ROLE', 0);
