const mongoose = require('mongoose');
const UserSchema = require('../../schema/mongoose/user.schema');
const { DB_URL } = require('../../utils/constants');

const userSvcConn = mongoose.createConnection(DB_URL.USER_SERVICE);
const UserModel = userSvcConn.model('UserModel', UserSchema, 'users');

module.exports = {
	userSvcConn,
	UserModel,
};
