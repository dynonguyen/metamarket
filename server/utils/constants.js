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
};
