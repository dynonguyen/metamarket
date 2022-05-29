const { SVC_NAME } = require('../../utils/constants');
const productAction = require('./actions/product.action');


module.exports = {
	name: SVC_NAME.AGGREGATE,

	actions: {
		...productAction,
	},

	events: {
		'user.call'(ctx) {
			console.log('HOOOOOOOOOOOOOOOOOOOOOOOOOOO');
		},
	},
};
