const { default: mongoose } = require('mongoose');
const { SVC_NAME } = require('../../utils/constants');
const { AppReview, Comment, ShopReview } = require('./review.db');
const { MoleculerError } = require('moleculer').Errors;

module.exports = {
	getCommentByProductId: {
		cache: {
			ttl: 300,
			keys: ['productId'],
		},
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
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	postAddProductComment: {
		cache: false,
		params: {
			productId: {
				type: 'string',
				length: 24,
			},
			rate: {
				type: 'number',
				min: 1,
				max: 5,
			},
			content: 'string',
			fullname: 'string',
			email: {
				type: 'string',
				optional: true,
			},
			isAnonymous: {
				type: 'boolean',
				default: false,
			},
		},
		async handler(ctx) {
			const {
				productId,
				rate,
				content,
				fullname,
				email = '',
				isAnonymous,
			} = ctx.params;
			try {
				// check if the user has commented
				const isExist = await Comment.findOne({ 'customerInfo.email': email });
				if (isExist) {
					ctx.meta.$statusCode = 403;
					return false;
				}

				// Get product to update it
				const product = await ctx.call(
					`${SVC_NAME.PRODUCT}.getReviewSummaryById`,
					{ productId },
				);

				if (product) {
					// Update new rate average
					const { reviewTotal } = product;
					const avgComment = await Comment.aggregate([
						{
							$match: {
								productId: mongoose.Types.ObjectId(productId),
							},
						},
						{ $group: { _id: null, sum: { $sum: '$rate' } } },
					]).exec();
					const sumRate = avgComment[0].sum;
					await ctx.call(`${SVC_NAME.PRODUCT}.putUpdateProductById`, {
						productId,
						updateFields: {
							rateAvg: (sumRate + rate) / (reviewTotal + 1),
							reviewTotal: reviewTotal + 1,
						},
					});

					// create new comment
					const comment = await Comment.create({
						productId,
						rate,
						content,
						isAnonymous,
						customerInfo: { fullname, email },
						createdAt: new Date(),
					});

					if (comment) {
						// Clean cache to reload product page
						ctx.emit(`${SVC_NAME.REVIEW}.createComment`, { productId });
						ctx.meta.$statusCode = 201;
						return true;
					}
				}

				throw new Error('Created Failed');
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
