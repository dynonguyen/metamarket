const mongoose = require('mongoose');
const { Schema } = mongoose;

const UserSchema = new Schema({
	firstName: {
		type: String,
		required: true,
		maxLength: 50,
		trim: true,
	},
	lastName: {
		type: String,
		required: true,
		maxLength: 50,
		trim: true,
	},
	age: {
		type: Number,
		min: 0,
		max: 100,
	},
});

module.exports = UserSchema;
