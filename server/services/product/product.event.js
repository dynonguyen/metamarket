const { SVC_NAME } = require('../../utils/constants');

module.exports = {
	[`${SVC_NAME.REVIEW}.createComment`](ctx) {
		if (this.broker) {
			this.broker.cacher.clean([
				`${SVC_NAME.PRODUCT}.getProductDetailById:${ctx.params.productId}`,
				`${SVC_NAME.PRODUCT}.getBasicProductInfoById:${ctx.params.productId}`,
			]);
		}
	},
};
