const { SVC_NAME } = require('../../utils/constants');
const {
	ShopChat,
	SystemChat,
	AnonymousShopChat,
	AnonymousSysChat,
} = require('./support.db');

module.exports = {
	name: SVC_NAME.SUPPORT,

	actions: {
		demo(ctx) {
			return 'Hi support';
		},
	},
};
