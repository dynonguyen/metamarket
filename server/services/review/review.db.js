const { default: mongoose } = require('mongoose');
const AppReviewSchema = require('../../schema/mongoose/app-review.schema');
const CommentSchema = require('../../schema/mongoose/comment.schema');
const ShopReviewSchema = require('../../schema/mongoose/shop-review.schema');
const { DB_CONFIG, MONGOOSE_MODEL_NAME } = require('../../utils/constants');

const reviewSvcConn = mongoose.createConnection(DB_CONFIG.REVIEW_SERVICE.URL);

const Comment = reviewSvcConn.model(
	MONGOOSE_MODEL_NAME.COMMENT,
	CommentSchema,
	'comments',
);

const ShopReview = reviewSvcConn.model(
	MONGOOSE_MODEL_NAME.SHOP_REVIEW,
	ShopReviewSchema,
	'shopReviews',
);

const AppReview = reviewSvcConn.model(
	MONGOOSE_MODEL_NAME.APP_REVIEW,
	AppReviewSchema,
	'appReviews',
);

module.exports = {
	AppReview,
	Comment,
	ShopReview,
};
