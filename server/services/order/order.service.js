const { SVC_NAME } = require('../../utils/constants');
const { Order } = require('./order.db');

module.exports = {
	name: SVC_NAME.ORDER,
	actions: {
		demo(ctx) {
			return 'Hello Order';
		},
	},
};
