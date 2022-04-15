module.exports = {
	// Services name
	SVC_NAME: {
		GATEWAY: 'gateway',
		USER: 'user',
		PRODUCT: 'product',
	},

	// Database URL
	DB_CONFIG: {
		PRODUCT_SERVICE: {
			URL:
				process.env.PRODUCT_SERVICE_DB_URL ||
				'mongodb://localhost/product_service',
		},

		USER_SERVICE: {
			DB_NAME: process.env.USER_SERVICE_DB_NAME || 'user_service',
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
		PRODUCT: 'Product',
		CATALOG: 'Catalog',
		CATEGORY: 'Category',
		PRODUCT_DETAIL: 'ProductDetail',
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
	},

	PAYMENT_METHOD: {
		COD: 0,
		PAYPAL: 1,
	},
};
