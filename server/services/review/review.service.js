const { SVC_NAME } = require('../../utils/constants');
const reviewActions = require('./review.action');
const reviewEvents = require('./review.event');

module.exports = {
	name: SVC_NAME.REVIEW,

	actions: {
		...reviewActions,
	},

	events: {
		...reviewEvents,
	},
};
