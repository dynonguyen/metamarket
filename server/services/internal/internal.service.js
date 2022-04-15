const { SVC_NAME } = require('../../utils/constants');
const { Shipper, AdminAccount } = require('./internal.db');

module.exports = {
	name: SVC_NAME.INTERNAL,

	actions: {
		demo(ctx) {
			ctx.emit('user.call');
			return 'Hi internal';
		},
	},
};