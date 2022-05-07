const { SVC_NAME } = require('../../utils/constants');
const { Shipper, AdminAccount } = require('./internal.db');

module.exports = {
	name: SVC_NAME.INTERNAL,

	actions: {
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
					return null;
				}
			},
		},
	},
};
