const { MoleculerError } = require('moleculer').Errors;
const { UserPayment, ShopPayment } = require('./payment.db');

module.exports = {
	postCreateUserPayment: {
		params: {
			userId: [{ type: 'number' }, { type: 'string', numeric: true }],
			orderCode: 'string',
			paymentType: [{ type: 'number' }, { type: 'string', numeric: true }],
			transactionCode: 'string',
			totalMoney: [{ type: 'number' }, { type: 'string', numeric: true }],
			note: { type: 'string', optional: true, default: '' },
		},
		async handler(ctx) {
			const {
				userId,
				orderCode,
				paymentType,
				transactionCode,
				totalMoney,
				note,
			} = ctx.params;
			try {
				const payment = await UserPayment.create({
					userId,
					orderCode,
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
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
