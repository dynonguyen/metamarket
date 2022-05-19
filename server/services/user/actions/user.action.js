const {
	SVC_NAME,
	ACCOUNT_STATUS,
	ACCOUNT_TYPE,
} = require('../../../utils/constants');
const {
	Province,
	User,
	Account,
	Contract,
	District,
	Shop,
	UserAddress,
	Ward,
	userDb,
} = require('../user.db');

const { MoleculerError } = require('moleculer').Errors;
module.exports = {
	postCreateShop: {
		params: {
			email: 'string',
			password: 'string',
			phone: 'string',
			foundingDate: [{ type: 'string' }],
			name: 'string',
			supporterName: 'string',
			catalogId: 'string',
			openHours: 'string',
			businessLicense: { type: 'string', optional: true, default: '' },
			foodSafetyCertificate: { type: 'string', optional: true, default: '' },
			logoUrl: { type: 'string', optional: true, default: '' },
		},

		async handler(ctx) {
			const tx = await userDb.transaction();

			try {
				const {
					email,
					password,
					phone,
					foundingDate,
					name,
					supporterName,
					catalogId,
					openHours,
					businessLicense = '',
					foodSafetyCertificate = '',
					logoUrl = '',
				} = ctx.params;

				const account = await Account.create(
					{
						email,
						password,
						status: ACCOUNT_STATUS.WAITING_APPROVAL,
						type: ACCOUNT_TYPE.SHOP,
						googleId: '',
						createdAt: new Date(),
					},
					{ transaction: tx },
				);

				const shop = await Shop.create(
					{
						accountId: account.accountId,
						phone,
						foundingDate: new Date(foundingDate),
						name,
						supporterName,
						catalogId,
						openHours,
						logoUrl,
					},
					{ transaction: tx },
				);

				const contract = await Contract.create(
					{
						shopId: shop.shopId,
						businessLicense,
						foodSafetyCertificate,
						isOriginCommitment: true,
						isCustomerCareCommitment: true,
						isPolicyCommitment: true,
					},
					{ transaction: tx },
				);

				await tx.commit();

				return { shopId: shop.shopId };
			} catch (error) {
				await tx.rollback();
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
