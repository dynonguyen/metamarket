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
	brand: {
		type: String,
		required: true,
	},
	desc: {
		type: String,
		required: false,
		default: '',
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
