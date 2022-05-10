const { SVC_NAME } = require('../../utils/constants');
const orderActions = require('./order.action');

module.exports = {
	name: SVC_NAME.ORDER,
	actions: {
		...orderActions,
	},
};
