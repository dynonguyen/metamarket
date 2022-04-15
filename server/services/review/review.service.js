const { SVC_NAME } = require('../../utils/constants');
const { AppReview, Comment, ShopReview } = require('./review.db');

module.exports = {
	name: SVC_NAME.REVIEW,

	actions: {
		demo(ctx) {
			return 'Hi review';
		},
	},
};
