const { SVC_NAME } = require('../../utils/constants');
const {
	Province,
	User,
	Account,
	Contract,
	District,
	Shop,
	UserAddress,
	Ward,
} = require('./user.db');

module.exports = {
	name: SVC_NAME.USER,

	actions: {},
};
