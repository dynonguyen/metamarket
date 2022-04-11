const { sequelizeConnect } = require('../../configs/sequelize');
const UserSchema = require('../../schema/mysql/user.schema');
const { DB_CONFIG } = require('../../utils/constants');

const userDb = sequelizeConnect({
	dbName: DB_CONFIG.USER_SERVICE.DB_NAME,
	hostname: DB_CONFIG.USER_SERVICE.HOSTNAME,
	dialect: 'mysql',
	username: DB_CONFIG.USER_SERVICE.USERNAME,
	password: DB_CONFIG.USER_SERVICE.PASSWORD,
});

userDb.sync({ alter: true });

const User = userDb.define(...UserSchema);

module.exports = User;
