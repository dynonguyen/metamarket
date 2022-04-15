const mongoose = require('mongoose');
const { USER_VOCATIVE } = require('../../utils/constants');
const { Schema } = mongoose;

const AnonymousSysChatSchema = new Schema({
	sessionId: {
		type: Schema.Types.ObjectId,
		require: true,
	},
	user: {
		vocative: {
			type: String,
			required: true,
			trim: true,
			default: `${USER_VOCATIVE.MALE} / ${USER_VOCATIVE.FEMALE}`,
		},
		fullname: {
			type: String,
			required: true,
			trim: true,
		},
		contact: String,
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

module.exports = AnonymousSysChatSchema;
