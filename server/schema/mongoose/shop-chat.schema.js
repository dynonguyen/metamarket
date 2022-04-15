const mongoose = require('mongoose');
const { Schema } = mongoose;

const ShopChatSchema = new Schema({
	userId: {
		type: Number,
		require: true,
	},
	shopId: {
		type: Number,
		require: true,
	},
	createdAt: {
		type: Date,
		default: new Date(),
	},
	history: [
		{
			isUser: Boolean,
			content: {
				type: String,
				required: true,
				trim: true,
			},
			time: {
				type: Date,
				required: true,
				default: new Date(),
			},
		},
	],
});

module.exports = ShopChatSchema;
