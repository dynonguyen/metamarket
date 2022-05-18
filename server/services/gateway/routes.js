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
	'GET products/search': `${PRODUCT_SVC}.searchProduct`,
	'GET products/get-shop/:productId': `${PRODUCT_SVC}.getShopByProductId`,

	'POST products/add-product': `${PRODUCT_SVC}.postAddProduct`,
	'PUT products/desc-stock': `${PRODUCT_SVC}.putDecreaseProductStockById`,
};

const aggregateAliases = {
	'GET aggregates/homepage-products': `${AGGREGATE_SVC}.getHomepageProducts`,
	'GET aggregates/product-details/:productId': `${AGGREGATE_SVC}.getProductDetailPage`,
};

const orderAliases = {
	'POST orders/create': `${ORDER_SVC}.postCreateOrder`,
	'GET orders/exist/by-order-code/:orderCode': `${ORDER_SVC}.getCheckExistByOrderCode`,
};

const paymentAliases = {
	'POST payments/user/create': `${PAYMENT_SVC}.postCreateUserPayment`,
};

const reviewAliases = {
	'POST reviews/add-product-comment': `${REVIEW_SVC}.postAddProductComment`,
};

const userAliases = {
	'GET users/address/province/all': `${USER_SVC}.getAllProvinces`,
	'GET users/address/district/by-province/:provinceId': `${USER_SVC}.getDistrictsByProvinceId`,
	'GET users/address/ward/by-district/:districtId': `${USER_SVC}.getWardsByDistrictId`,

	'POST users/account/create-shop': `${USER_SVC}.postCreateShop`,
};

const supportAliases = {
	'GET support/chat-shop-user/:shopId/:userId': `${SUPPORT_SVC}.getShopChatHistory`,
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
			...orderAliases,

			// Payment service
			...paymentAliases,

			// Product service
			...productAliases,

			// Review service
			...reviewAliases,

			// Shipping service

			// Shop service

			// Support service
			...supportAliases,

			// User service
			...userAliases,
		},
	},
];
