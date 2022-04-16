const { SVC_NAME } = require('../../utils/constants');
const { Product, Catalog, Category, ProductDetail } = require('./product.db');
const catalogActions = require('./actions/catalog.action');

module.exports = {
	name: SVC_NAME.PRODUCT,

	actions: {
		demo: {
			cache: false,

			async handler(ctx) {
				return 'Hello product';
			},
		},

		...catalogActions,
	},
};
