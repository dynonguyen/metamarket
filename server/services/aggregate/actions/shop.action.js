const { SVC_NAME } = require('../../../utils/constants');

const { MoleculerError } = require('moleculer').Errors;

module.exports = {
	getShopStatisticOverview: {
		cache: false,
		params: { shopId: ['number', { type: 'string', numeric: true }] },
		async handler(ctx) {
			const { shopId } = ctx.params;
			try {
				const promises = [];
				let result = {
					revenue: 0,
					order: 0,
					review: 0,
					product: 0,
				};

				// count shop's order
				promises.push(
					ctx
						.call(`${SVC_NAME.ORDER}.getCountOrderByShop`, { shopId })
						.then((count) => (result.order = count)),
				);

				// count shop's product
				promises.push(
					ctx
						.call(`${SVC_NAME.PRODUCT}.getCountProductByShop`, { shopId })
						.then((count) => (result.product = count)),
				);

				// count shop's review
				promises.push(
					ctx
						.call(`${SVC_NAME.REVIEW}.getCountReviewByShop`, { shopId })
						.then((count) => (result.review = count)),
				);

				// calculate revenue
				promises.push(
					ctx
						.call(`${SVC_NAME.ORDER}.getShopRevenue`, { shopId })
						.then((total) => (result.revenue = total)),
				);

				await Promise.all(promises);
				return result;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
