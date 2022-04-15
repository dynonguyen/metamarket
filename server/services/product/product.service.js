const { SVC_NAME } = require('../../utils/constants');
const { Product, Catalog, Category, ProductDetail } = require('./product.db');

module.exports = {
	name: SVC_NAME.PRODUCT,

	actions: {
		demo: {
			cache: false,

			async handler(ctx) {
				return 'Hello product';
			},
		},
	},
};
