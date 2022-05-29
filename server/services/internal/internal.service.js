const { SVC_NAME } = require('../../utils/constants');
const { Shipper, AdminAccount } = require('./internal.db');
const shipperAction = require('./actions/shipper.action');

module.exports = {
	name: SVC_NAME.INTERNAL,

	actions: {
		...shipperAction,
	},
};
