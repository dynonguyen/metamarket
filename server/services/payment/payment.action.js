const { MoleculerError } = require('moleculer').Errors;
const { UserPayment, ShopPayment } = require('./payment.db');

module.exports = {
	postCreateUserPayment: {
		params: {
			userId: [{ type: 'number' }, { type: 'string', numeric: true }],
			orderId: 'string',
			paymentType: [{ type: 'number' }, { type: 'string', numeric: true }],
			transactionCode: 'string',
			totalMoney: [{ type: 'number' }, { type: 'string', numeric: true }],
			note: { type: 'string', optional: true, default: '' },
		},
		async handler(ctx) {
			const {
				userId,
				orderId,
				paymentType,
				transactionCode,
				totalMoney,
				note,
			} = ctx.params;
			try {
				const payment = await UserPayment.create({
					userId,
					orderId,
					paymentType,
					transactionCode,
					totalMoney,
					note,
				});

				if (payment) {
					return true;
				}

				throw new Error('Create Failed');
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
