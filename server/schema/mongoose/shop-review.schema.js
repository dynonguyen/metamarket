const mongoose = require('mongoose');
const { Schema } = mongoose;

const ShopReviewSchema = new Schema({
	shopId: {
		type: Number,
		required: true,
	},
	rate: {
		type: Number,
		min: 0,
		max: 5,
		default: -1,
	},
	content: {
		type: String,
		required: true,
	},
	createdAt: {
		type: Date,
		required: true,
		default: new Date(),
	},
	customerInfo: {
		fullname: {
			type: String,
			required: true,
		},
		email: String,
	},
	isAnonymous: {
		type: Boolean,
		default: false,
	},
});

module.exports = ShopReviewSchema;
