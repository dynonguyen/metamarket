const { SVC_NAME, DEFAULT } = require('../../../utils/constants');
const { MoleculerError } = require('moleculer').Errors;

module.exports = {
	getHomepageProducts: {
		cache: {
			ttl: 5 * 60,
		},

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
								select: '_id name price discount avt unit',
							})
							.then((products) => {
								result.push({
									catalogName: catalog.name,
									products,
								});
							}),
					);
				});

				await Promise.all(promises);

				return result;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
