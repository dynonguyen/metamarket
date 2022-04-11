module.exports = {
	// Services name
	SVC_NAME: {
		GATEWAY: "gateway",
		USER: "user",
		PRODUCT: "product",
	},

	// Database URL
	DB_URL: {
		USER_SERVICE:
			process.env.USER_SERVICE_DB_URL ||
			"mongodb://localhost/user-service",
		PRODUCT_SERVICE:
			process.env.PRODUCT_SERVICE_DB_URL ||
			"mongodb://localhost/product-service",
	},
};
