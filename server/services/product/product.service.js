const { SVC_NAME } = require('../../utils/constants');
const catalogActions = require('./actions/catalog.action');
const productAction = require('./actions/product.action');

module.exports = {
	name: SVC_NAME.PRODUCT,

	actions: {
		...catalogActions,
		...productAction,
	},
};
