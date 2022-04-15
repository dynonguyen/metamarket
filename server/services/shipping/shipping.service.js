const { SVC_NAME } = require('../../utils/constants');

module.exports = {
	name: SVC_NAME.SHIPPING,

	actions: {
		demo(ctx) {
			return 'Hi shipping';
		},
	},
};
