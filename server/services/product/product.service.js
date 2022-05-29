const { SVC_NAME } = require('../../utils/constants');
const catalogActions = require('./actions/catalog.action');
const productActions = require('./actions/product.action');
const productEvents = require('./product.event');

module.exports = {
	name: SVC_NAME.PRODUCT,

	actions: {
		...catalogActions,
		...productActions,
	},

	events: {
		...productEvents,
	},
};
