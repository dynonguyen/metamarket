const { MoleculerError } = require('moleculer').Errors;
const { SVC_NAME } = require('../../utils/constants');
const { Shipper, AdminAccount } = require('./internal.db');
const shipperAction = require('./actions/shipper.action');

module.exports = {
	name: SVC_NAME.INTERNAL,

	actions: {
		...shipperAction,
		getAccountByUsername: {
			cache: false,

			params: {
				username: 'string',
			},

			async handler(ctx) {
				const { username } = ctx.params;
				try {
					const adminAccount = await AdminAccount.findOne({
						raw: true,
						where: {
							username,
						},
					});
					if (adminAccount) {
						return adminAccount;
					}
					return null;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		getShipperByUsername: {
			cache: false,

			params: {
				username: 'string',
			},

			async handler(ctx) {
				const { username } = ctx.params;
				try {
					const shipper = await Shipper.findOne({
						raw: true,
						where: {
							username,
						},
					});
					if (shipper) {
						return shipper;
					}
					return null;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		getAdminById: {
			cache: false,

			params: {
				accountId: [{ type: 'number' }, { type: 'string', numeric: true }],
			},

			async handler(ctx) {
				const { accountId } = ctx.params;
				try {
					const admin = await AdminAccount.findOne({
						raw: true,
						where: {
							accountId,
						},
					});
					if (admin) {
						return admin;
					}
					return null;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		getShipperById: {
			cache: false,

			params: {
				shipperId: [{ type: 'number' }, { type: 'string', numeric: true }],
			},

			async handler(ctx) {
				const { shipperId } = ctx.params;
				try {
					const shipper = await Shipper.findOne({
						raw: true,
						where: {
							shipperId,
						},
					});
					if (shipper) {
						return shipper;
					}
					return null;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},
	},
};
