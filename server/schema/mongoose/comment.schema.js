const mongoose = require('mongoose');
const { Schema } = mongoose;

const CommentSchema = new Schema({
	productId: {
		type: Schema.Types.ObjectId,
		required: true,
	},
	rate: {
		type: Number,
		required: true,
		min: 0,
		max: 5,
		default: 0,
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

module.exports = CommentSchema;
