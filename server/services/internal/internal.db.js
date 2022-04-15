const { sequelizeConnect } = require('../../configs/sequelize');
const AdminAccountSchema = require('../../schema/mysql/admin-account.schema');
const ShipperSchema = require('../../schema/mysql/shipper.schema');
const { DB_CONFIG } = require('../../utils/constants');

const internalDb = sequelizeConnect({
	dbName: DB_CONFIG.INTERNAL_SERVICE.DB_NAME,
	hostname: DB_CONFIG.INTERNAL_SERVICE.HOSTNAME,
	dialect: 'mysql',
	username: DB_CONFIG.INTERNAL_SERVICE.USERNAME,
	password: DB_CONFIG.INTERNAL_SERVICE.PASSWORD,
});

const Shipper = internalDb.define(...ShipperSchema);
const AdminAccount = internalDb.define(...AdminAccountSchema);

internalDb.sync({ alter: true });

module.exports = { Shipper, AdminAccount };
