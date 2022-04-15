const mongoose = require('mongoose');
const { MONGOOSE_MODEL_NAME, MAX } = require('../../utils/constants');
const { Schema } = mongoose;

const CategorySchema = new Schema({
	name: {
		type: String,
		required: true,
		maxlength: MAX.CATEGORY_NAME,
		trim: true,
	},
	link: {
		type: String,
		required: true,
		trim: true,
	},
	catalogId: {
		type: Schema.Types.ObjectId,
		ref: MONGOOSE_MODEL_NAME.CATALOG,
		required: true,
	},
});

module.exports = CategorySchema;
