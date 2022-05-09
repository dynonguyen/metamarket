const { SVC_NAME } = require('../../utils/constants');
const productActions = require('./actions/product.action');
const aggregateEvents = require('./aggregate.event');

module.exports = {
	name: SVC_NAME.AGGREGATE,

	actions: {
		...productActions,
	},

	events: {
		...aggregateEvents,
	},
};
