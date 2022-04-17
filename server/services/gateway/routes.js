const { SVC_NAME } = require('../../utils/constants');

const AGGREGATE_SVC = SVC_NAME.AGGREGATE;
const INTERNAL_SVC = SVC_NAME.INTERNAL;
const ORDER_SVC = SVC_NAME.ORDER;
const PAYMENT_SVC = SVC_NAME.PAYMENT;
const PRODUCT_SVC = SVC_NAME.PRODUCT;
const REVIEW_SVC = SVC_NAME.REVIEW;
const SHIPPING_SVC = SVC_NAME.SHIPPING;
const SHOP_SVC = SVC_NAME.SHOP;
const SUPPORT_SVC = SVC_NAME.SUPPORT;
const USER_SVC = SVC_NAME.USER;

const productAliases = {
	'GET products/demo': `${PRODUCT_SVC}.demo`,
	'GET products/catalogs': `${PRODUCT_SVC}.getAllCatalogs`,
};

module.exports = [
	{
		path: '/api/v1',
		whitelist: ['**'],
		authentication: false,
		autoAliases: false,
		mergeParams: true,

		bodyParsers: {
			json: true,
			urlencoded: { extended: true },
		},

		aliases: {
			// Aggregate service
			'GET aggregates/demo': `${AGGREGATE_SVC}.demo`,

			// Internal service
			'GET internal/demo': `${INTERNAL_SVC}.demo`,

			// Order service
			'GET orders/demo': `${ORDER_SVC}.demo`,

			// Payment service
			'GET payments/demo': `${PAYMENT_SVC}.demo`,

			// Product service
			...productAliases,

			// Review service
			'GET reviews/demo': `${REVIEW_SVC}.demo`,

			// Shipping service
			'GET shipping/demo': `${SHIPPING_SVC}.demo`,

			// Shop service
			'GET shops/demo': `${SHOP_SVC}.demo`,

			// Support service
			'GET support/demo': `${SUPPORT_SVC}.demo`,

			// User service
			'GET users/demo': `${USER_SVC}.demo`,
		},
	},
];
