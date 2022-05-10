const { SVC_NAME } = require('../../utils/constants');
const addressActions = require('./actions/address.action');

module.exports = {
	name: SVC_NAME.USER,

	actions: {
		...addressActions,
	},
};
