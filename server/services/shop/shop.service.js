const { SVC_NAME } = require('../../utils/constants');

module.exports = {
	name: SVC_NAME.SHOP,

	actions: {
		demo(ctx) {
			return 'Hi shop';
		},
	},
};
