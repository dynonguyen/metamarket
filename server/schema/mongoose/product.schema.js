const mongoose = require('mongoose');
const { Schema } = mongoose;

const ProductSchema = new Schema({
	name: {
		type: String,
		required: true,
		maxLength: 50,
		trim: true,
	},
	price: {
		type: Number,
		required: true,
		default: 0,
	},
	desc: {
		type: String,
		required: false,
		trim: true,
	},
});

module.exports = ProductSchema;
