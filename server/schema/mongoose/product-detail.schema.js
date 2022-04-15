const mongoose = require('mongoose');
const { MONGOOSE_MODEL_NAME } = require('../../utils/constants');
const { Schema } = mongoose;

const ProductDetailSchema = new Schema({
	productId: {
		type: Schema.Types.ObjectId,
		ref: MONGOOSE_MODEL_NAME.PRODUCT,
		required: true,
	},
	photos: [String],
	origin: {
		type: String,
		required: true,
	},
	branch: {
		type: String,
		required: true,
	},
	infos: [
		{
			label: {
				type: String,
				required: true,
			},
			detail: {
				type: String,
				required: true,
			},
		},
	],
});

module.exports = ProductDetailSchema;
