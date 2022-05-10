const {
	ORDER_STATUS,
	PAYMENT_METHOD,
	SVC_NAME,
} = require('../../utils/constants');
const { Order } = require('./order.db');
const { MoleculerError } = require('moleculer').Errors;

module.exports = {
	postCreateOrder: {
		params: {
			userId: [{ type: 'number' }, { type: 'string', numeric: true }],
			orderCode: 'string',
			receiverName: 'string',
			receiverPhone: 'string',
			isPayment: 'boolean',
			wardId: [{ type: 'number' }, { type: 'string', numeric: true }],
			addrDetail: 'string',
			products: 'any',
			paymentMethod: [{ type: 'number' }, { type: 'string', numeric: true }],
			transportFee: [{ type: 'number' }, { type: 'string', numeric: true }],
			orderTotal: [{ type: 'number' }, { type: 'string', numeric: true }],
			note: { type: 'string', optional: true, default: '' },
		},
		async handler(ctx) {
			const {
				userId,
				orderCode,
				receiverName,
				receiverPhone,
				isPayment,
				wardId,
				addrDetail,
				products,
				paymentMethod,
				transportFee,
				orderTotal,
				note = '',
			} = ctx.params;

			try {
				const fullAddrStr = await ctx.call(
					`${SVC_NAME.USER}.getFullAddressByWardId`,
					{ wardId },
				);

				const order = await Order.create({
					userId,
					orderCode,
					orderDate: new Date(),
					shipperId: -1,
					orderStatus: ORDER_STATUS.PENDING_SHOP,
					deliveryAddress: {
						addrDetail,
						wardId,
						fullAddrStr: `${addrDetail}, ${fullAddrStr}`,
					},
					receiverName,
					receiverPhone,
					products,
					paymentMethod,
					isPayment,
					transportFee,
					orderTotal,
					note,
				});

				if (order) {
					return order._id;
				}

				throw new Error('Create Failed');
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getCheckExistByOrderCode: {
		params: {
			orderCode: 'string',
		},
		async handler(ctx) {
			try {
				const order = await Order.findOne({ orderCode: ctx.params.orderCode });
				if (order) {
					return true;
				}
				return false;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
