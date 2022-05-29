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

// static file server
define('STATIC_FILE_URL', $_ENV['STATIC_FILE_URL'] ?? '/public');

// Default
define('DEFAULT_PRODUCT_AVT', STATIC_FILE_URL . '/assets/images/product-not-found.png');
define('DEFAULT_SHOP_AVT', STATIC_FILE_URL . '/assets/images/shop-not-found.png');
define('DEFAULT_PAGE_SIZE', 10);

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

// Gender
define('MALE', 1);
define('FEMALE', 0);

// Mailer
define('MAIL_EXP', 10); // 10 minutes
define('MAIL_HOST', $_ENV['MAIL_HOST'] ?? 'stmp.gmail.com');
define('MAIL_USERNAME', $_ENV['MAIL_USERNAME'] ?? '');
define('MAIL_PASSWORD', $_ENV['MAIL_PASSWORD'] ?? '');

define('CONTACT_PHONE', $_ENV['CONTACT_PHONE'] ?? '');
define('SHIPPING_FEE', 25000);

define('MOMO_PARTNER_CODE', $_ENV['MOMO_PARTNER_CODE'] ?? '');
define('MOMO_ACCESS_KEY', $_ENV['MOMO_ACCESS_KEY'] ?? '');
define('MOMO_SECRET_KEY', $_ENV['MOMO_SECRET_KEY'] ?? '');
define('MOMO_ENDPOINT', $_ENV['MOMO_ENDPOINT'] ?? '');

define('PAYMENT_METHOD', ['COD' => 0, 'MOMO' => 1]);

define('ACCOUNT_STATUS', [
    'LOCKED' => -1,
    'WAITING_APPROVAL' => 0,
    'ACTIVE' => 1
]);

define('CHAT_SOCKET_SERVER', $_ENV['CHAT_SOCKET_SERVER'] ?? 'http://localhost:4444');

define('ORDER_STATUS',  [
    'PROCESSING' => 0,
    'PENDING_PAYMENT' => 1,
    'PENDING_SHOP' => 2,
    'SHIPPING' => 3,
    'COMPLETE' => 4,
    'CANCELED' => 5,
]);