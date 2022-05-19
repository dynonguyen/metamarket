require('./socker-server');
const { SVC_NAME } = require('../../utils/constants');
const supportActions = require('./support.action');

module.exports = {
	name: SVC_NAME.SUPPORT,

	actions: {
		...supportActions,
	},
};
