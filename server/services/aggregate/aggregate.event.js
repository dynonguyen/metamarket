const { SVC_NAME } = require('../../utils/constants');

module.exports = {
	[`${SVC_NAME.REVIEW}.createComment`](ctx) {
		if (this.broker) {
			this.broker.cacher.clean([
				`${SVC_NAME.AGGREGATE}.getProductDetailPage:${ctx.params.productId}`,
			]);
		}
	},
	[`${SVC_NAME.PRODUCT}.createProduct`](ctx) {
		if (this.broker) {
			this.broker.cacher.clean([`${SVC_NAME.AGGREGATE}.getHomepageProducts`]);
		}
	},
};
