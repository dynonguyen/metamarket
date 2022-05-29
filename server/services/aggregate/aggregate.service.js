const { SVC_NAME } = require('../../utils/constants');
const productActions = require('./actions/product.action');
const shopActions = require('./actions/shop.action');
const aggregateEvents = require('./aggregate.event');

module.exports = {
	name: SVC_NAME.AGGREGATE,

	actions: {
		...productActions,
		...shopActions,
	},

	events: {
		...aggregateEvents,
	},
};
