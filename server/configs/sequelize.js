const Sequelize = require('sequelize').Sequelize;
const { Op, DataTypes } = require('sequelize');

const sequelizeConnect = ({
	hostname = 'localhost',
	dbName = '',
	username = 'root',
	password = '',
	dialect = 'mysql',
	options = {
		logging: false,
	},
}) => {
	return new Sequelize(dbName, username, password, {
		host: hostname,
		dialect: dialect,
		...options,
	});
};

module.exports = {
	sequelizeConnect,
	Op,
	DataTypes,
};
