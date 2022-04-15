const mongoose = require('mongoose');
const { ORDER_STATUS, PAYMENT_METHOD } = require('../../utils/constants');
const { Schema } = mongoose;

const OrderSchema = new Schema({
	userId: {
		type: Number,
		required: true,
	},
	orderCode: {
		type: String,
		required: true,
	},
	orderDate: {
		type: Date,
		required: true,
		default: new Date(),
	},
	shipperId: {
		type: Number,
		required: true,
	},
	orderStatus: {
		type: Number,
		required: true,
		default: ORDER_STATUS.PROCESSING,
	},
	deliveryAddress: {
		addrDetail: {
			type: String,
			required: true,
		},
		wardId: {
			type: Number,
			required: true,
		},
		fullAddrStr: String,
	},
	receiverName: {
		type: String,
		required: true,
		trim: true,
	},
	receiverPhone: {
		type: String,
		required: true,
		trim: true,
	},
	products: [
		{
			productId: {
				type: Schema.Types.ObjectId,
				required: true,
			},
			shopId: {
				type: Schema.Types.ObjectId,
				required: true,
			},
			price: Number,
			quantity: Number,
			discount: Number,
		},
	],
	paymentMethod: {
		type: Number,
		required: true,
		default: PAYMENT_METHOD.COD,
	},
	transportFee: {
		type: Number,
		required: true,
		default: 0,
	},
	note: {
		type: String,
		trim: true,
	},
});

module.exports = OrderSchema;
