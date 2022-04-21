const { SVC_NAME } = require('../../utils/constants');
const { AppReview, Comment, ShopReview } = require('./review.db');
const { MoleculerError } = require('moleculer').Errors;

module.exports = {
	name: SVC_NAME.REVIEW,

	actions: {
		getCommentByProductId: {
			cache: false,
			params: {
				productId: {
					type: 'string',
					length: 24,
				},
			},
			async handler(ctx) {
				const { productId } = ctx.params;
				try {
					const comments = await Comment.find({ productId }).select(
						'-_id -productId',
					);
					return comments;
				} catch (error) {
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},
	},
};
