const { SVC_NAME } = require('../../utils/constants');
const paymentActions = require('./payment.action');

module.exports = {
	name: SVC_NAME.PAYMENT,

	actions: {
		...paymentActions,
	},
};
