const mongoose = require('mongoose');
const { Schema } = mongoose;

const SystemChatSchema = new Schema({
	userId: {
		type: Number,
		require: true,
	},
	adminId: {
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

module.exports = SystemChatSchema;
