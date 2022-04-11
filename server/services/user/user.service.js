const { SVC_NAME } = require('../../utils/constants');
const User = require('./user-db');

module.exports = {
	name: SVC_NAME.USER,

	actions: {
		list: {
			cache: false,

			async handler(ctx) {
				const users = User.findAll({});
				return users;
			},
		},
	},
};
