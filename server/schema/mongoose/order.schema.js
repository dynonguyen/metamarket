const mongoose = require('mongoose');
const { ORDER_STATUS, PAYMENT_METHOD } = require('../../utils/constants');
const { Schema } = mongoose;

const OrderSchema = new Schema({
	userId: {
		type: Number,
		required: true,
	},
	shopId: {
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
		default: -1,
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
			price: Number,
			quantity: Number,
			discount: Number,
		},
	],
	paymentMethod: {
		type: Number,
		required: true,
		default: PAYMENT_METHOD.MOMO,
	},
	transportFee: {
		type: Number,
		required: true,
		default: 0,
	},
	isPayment: {
		type: Boolean,
		required: true,
		default: false,
	},
	note: {
		type: String,
		trim: true,
	},
	orderTotal: {
		type: Number,
		default: 0,
	},
});

module.exports = OrderSchema;
