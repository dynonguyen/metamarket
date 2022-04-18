const mongoose = require('mongoose');
const { MONGOOSE_MODEL_NAME, MAX, DEFAULT } = require('../../utils/constants');
const { Schema } = mongoose;

const ProductSchema = new Schema({
	catalogId: {
		type: Schema.Types.ObjectId,
		ref: MONGOOSE_MODEL_NAME.CATALOG,
		required: true,
	},
	categoryId: {
		type: Number,
		required: true,
	},
	shopId: {
		type: Number,
		required: true,
	},
	code: {
		type: String,
		required: false,
		default: '',
		trim: true,
	},
	name: {
		type: String,
		required: true,
		maxlength: MAX.PRODUCT_NAME,
		trim: true,
	},
	price: {
		type: Number,
		required: true,
		min: 0,
		max: MAX.PRODUCT_PRICE,
		default: 0,
	},
	stock: {
		type: Number,
		required: true,
		min: 0,
		max: MAX.PRODUCT_STOCK,
		default: 0,
	},
	discount: {
		type: Number,
		required: false,
		default: 0,
		min: 0,
		max: 100,
	},
	purchaseTotal: {
		type: Number,
		required: true,
		default: 0,
	},
	reviewTotal: {
		type: Number,
		required: true,
		default: 0,
	},
	rateAvg: {
		type: Number,
		required: true,
		default: 0,
	},
	avt: {
		type: String,
		required: true,
		default: DEFAULT.PRODUCT_AVT,
		trim: true,
	},
	unit: {
		type: String,
		required: true,
		default: DEFAULT.PRODUCT_UNIT,
		trim: true,
	},
	mfg: {
		type: Date,
		required: true,
	},
	exp: {
		type: Date,
		required: true,
	},
});

module.exports = ProductSchema;
