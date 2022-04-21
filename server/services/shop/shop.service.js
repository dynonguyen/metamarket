const { SVC_NAME } = require('../../utils/constants');
const { Shop, Account } = require('../user/user.db');
const { Sequelize } = require('sequelize');

module.exports = {
	name: SVC_NAME.SHOP,

	actions: {
		getShopById: {
			cache: false,
			params: {
				shopId: [
					{
						type: 'string',
						numeric: true,
					},
					{ type: 'number' },
				],
			},
			async handler(ctx) {
				try {
					const shopId = Number(ctx.params.shopId);
					const shop = await Shop.findOne({
						raw: true,
						attributes: {
							include: [
								[Sequelize.col('Account.email'), 'email'],
								[Sequelize.col('Account.status'), 'status'],
							],
						},
						where: {
							shopId,
						},
						include: {
							model: Account,
							attributes: [],
						},
					});
					return shop;
				} catch (error) {
					this.logger.error(error);
					return null;
				}
			},
		},
	},
};
