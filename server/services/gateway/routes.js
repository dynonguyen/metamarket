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
	'GET products/id/:productId': `${PRODUCT_SVC}.getBasicProductInfoById`,
	'GET products/catalogs': `${PRODUCT_SVC}.getAllCatalogs`,
	'GET products/catalog/:catalogLink': `${PRODUCT_SVC}.getCatalogByLink`,
	'GET products/list/catalog/:catalogId': `${PRODUCT_SVC}.getProductWithCatalog`,
	'GET products/list/category/:catalogId/:categoryId': `${PRODUCT_SVC}.getProductWithCategory`,
};

const aggregateAliases = {
	'GET aggregates/homepage-products': `${AGGREGATE_SVC}.getHomepageProducts`,
	'GET aggregates/product-details/:productId': `${AGGREGATE_SVC}.getProductDetailPage`,
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
			...aggregateAliases,

			// Internal service

			// Order service

			// Payment service

			// Product service
			...productAliases,

			// Review service

			// Shipping service

			// Shop service

			// Support service

			// User service
		},
	},
];
