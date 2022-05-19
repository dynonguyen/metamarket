const { SVC_NAME, DEFAULT } = require('../../../utils/constants');
const { MoleculerError } = require('moleculer').Errors;

module.exports = {
	getHomepageProducts: {
		cache: false,

		async handler(ctx) {
			const result = [];

			try {
				const catalogs = await ctx.call(`${SVC_NAME.PRODUCT}.getAllCatalogs`, {
					select: '-categories -link',
				});
				const promises = [];

				catalogs.forEach((catalog) => {
					promises.push(
						ctx
							.call(`${SVC_NAME.PRODUCT}.getProductWithCatalog`, {
								catalogId: catalog._id,
								page: '1',
								pageSize: DEFAULT.PAGE_SIZE.toString(),
								select: '_id name price discount avt unit stock',
							})
							.then((products) => {
								result.push({
									catalogId: catalog._id,
									catalogName: catalog.name,
									products,
								});
							}),
					);
				});

				await Promise.all(promises);

				return result;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getProductDetailPage: {
		cache: false,
		params: {
			productId: {
				type: 'string',
				length: 24,
			},
		},

		async handler(ctx) {
			try {
				const { productId } = ctx.params;

				let result = {
					product: null,
					productDetail: null,
					shop: null,
					reviews: [],
					otherProducts: [],
				};
				const promises = [];

				// detail
				promises.push(
					ctx
						.call(`${SVC_NAME.PRODUCT}.getProductDetailById`, { productId })
						.then((data) => (result.productDetail = data)),
				);

				// Comments
				promises.push(
					ctx
						.call(`${SVC_NAME.REVIEW}.getCommentByProductId`, { productId })
						.then((data) => (result.reviews = data)),
				);

				// basic info
				result.product = await ctx.call(
					`${SVC_NAME.PRODUCT}.getBasicProductInfoById`,
					{ productId },
				);

				// shop info
				promises.push(
					ctx
						.call(`${SVC_NAME.SHOP}.getShopById`, {
							shopId: result.product.shopId,
						})
						.then((data) => (result.shop = data)),
				);

				// shop's other products
				promises.push(
					ctx
						.call(`${SVC_NAME.PRODUCT}.getProductByShopId`, {
							shopId: result.product.shopId,
							limit: 8,
							select: '_id name price discount avt unit',
						})
						.then((data) => (result.otherProducts = data)),
				);

				await Promise.all(promises);
				return result;
			} catch (error) {
				this.logger.error(error);
				return null;
			}
		},
	},
};
