const { SVC_NAME } = require('../../utils/constants');
const { ProductModel } = require('./product-db');

module.exports = {
	name: SVC_NAME.PRODUCT,

	actions: {
		list: {
			cache: false,

			async handler(ctx) {
				try {
					const products = await ProductModel.find({});
					return 'Hello';
				} catch (error) {
					this.logger.error(error);
					return [];
				}
			},
		},

		getProductByName: {
			cache: false,
			params: {
				name: { type: 'string', min: 1 },
			},
			async handler(ctx) {
				const { params } = ctx;
				try {
					const product = await ProductModel.find({
						name: params.name,
					});
					return product;
				} catch (error) {
					this.logger.error(error);
					return null;
				}
			},
		},
	},
};
