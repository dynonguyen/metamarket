module.exports = {
	// Services name
	SVC_NAME: {
		AGGREGATE: 'aggregate',
		GATEWAY: 'gateway',
		INTERNAL: 'internal',
		ORDER: 'order',
		PAYMENT: 'payment',
		PRODUCT: 'product',
		REVIEW: 'review',
		SHIPPING: 'shipping',
		SHOP: 'shop',
		SUPPORT: 'support',
		USER: 'user',
	},

	// Database URL
	DB_CONFIG: {
		PRODUCT_SERVICE: {
			URL:
				process.env.PRODUCT_SERVICE_DB_URL ||
				'mongodb://localhost/product_service',
		},

		ORDER_SERVICE: {
			URL:
				process.env.ORDER_SERVICE_DB_URL || 'mongodb://localhost/order_service',
		},

		REVIEW_SERVICE: {
			URL:
				process.env.REVIEW_SERVICE_DB_URL ||
				'mongodb://localhost/review_service',
		},

		SUPPORT_SERVICE: {
			URL:
				process.env.SUPPORT_SERVICE_DB_URL ||
				'mongodb://localhost/support_service',
		},

		USER_SERVICE: {
			DB_NAME: process.env.USER_SERVICE_DB_NAME || 'user_service',
			HOSTNAME: process.env.MYSQL_HOSTNAME || 'localhost',
			USERNAME: process.env.MYSQL_USERNAME || 'root',
			PASSWORD: process.env.MYSQL_PASSWORD || '',
		},

		INTERNAL_SERVICE: {
			DB_NAME: process.env.INTERNAL_SERVICE_DB_NAME || 'internal_service',
			HOSTNAME: process.env.MYSQL_HOSTNAME || 'localhost',
			USERNAME: process.env.MYSQL_USERNAME || 'root',
			PASSWORD: process.env.MYSQL_PASSWORD || '',
		},

		PAYMENT_SERVICE: {
			DB_NAME: process.env.PAYMENT_SERVICE_DB_NAME || 'payment_service',
			HOSTNAME: process.env.MYSQL_HOSTNAME || 'localhost',
			USERNAME: process.env.MYSQL_USERNAME || 'root',
			PASSWORD: process.env.MYSQL_PASSWORD || '',
		},
	},

	// Status
	ACCOUNT_STATUS: {
		LOCKED: -1,
		WAITING_APPROVAL: 0,
		ACTIVE: 1,
	},

	ORDER_STATUS: {
		PROCESSING: 0,
		PENDING_PAYMENT: 1,
		PENDING: 2,
		SHIPPING: 3,
		COMPLETE: 4,
		CANCELED: 5,
	},

	// To create mongoose model & reference
	MONGOOSE_MODEL_NAME: {
		ANO_SHOP_CHAT: 'AnoShopChat',
		ANO_SYSTEM_CHAT: 'AnoSystemChat',
		APP_REVIEW: 'AppReview',
		CATALOG: 'Catalog',
		CATEGORY: 'Category',
		COMMENT: 'Comment',
		ORDER: 'Order',
		PRODUCT_DETAIL: 'ProductDetail',
		PRODUCT: 'Product',
		SHOP_CHAT: 'ShopChat',
		SHOP_REVIEW: 'ShopReview',
		SYSTEM_CHAT: 'SystemChat',
	},

	// Min, max
	MIN: {},
	MAX: {
		CATEGORY_NAME: 50,
		CATALOG_NAME: 50,
		PRODUCT_NAME: 150,
		PRODUCT_PRICE: 1_000_000_000,
		PRODUCT_STOCK: 1_000_000,
	},

	DEFAULT: {
		PRODUCT_AVT: '',
		PRODUCT_UNIT: 'Sản phẩm',
		PAGE_SIZE: 10,
	},

	PAYMENT_METHOD: {
		COD: 0,
		PAYPAL: 1,
	},

	USER_VOCATIVE: {
		MALE: 'Anh',
		FEMALE: 'Chị',
	},

	ADMIN_ACCOUNT_POSITION: {
		ADMIN: 1,
		SUPPORTER: 2,
	},

	CORS_URL: process.env.CORS_URL || '*',

	ACCOUNT_TYPE: {
		CUSTOMER: 1,
		SHOP: 2,
		SHIPPER: 3,
		ADMIN: 4,
	},
};
