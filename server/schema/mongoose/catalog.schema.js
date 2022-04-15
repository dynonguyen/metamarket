const mongoose = require('mongoose');
const { MAX } = require('../../utils/constants');
const { Schema } = mongoose;

const CatalogSchema = new Schema({
	name: {
		type: String,
		required: true,
		maxlength: MAX.CATALOG_NAME,
		trim: true,
	},
	link: {
		type: String,
		required: true,
		trim: true,
	},
});

module.exports = CatalogSchema;
