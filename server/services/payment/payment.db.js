const { sequelizeConnect } = require('../../configs/sequelize');
const ShopPaymentSchema = require('../../schema/mysql/shop-payment.schema');
const UserPaymentSchema = require('../../schema/mysql/user-payment.schema');
const { DB_CONFIG } = require('../../utils/constants');

const paymentDb = sequelizeConnect({
	dbName: DB_CONFIG.PAYMENT_SERVICE.DB_NAME,
	hostname: DB_CONFIG.PAYMENT_SERVICE.HOSTNAME,
	dialect: 'mysql',
	username: DB_CONFIG.PAYMENT_SERVICE.USERNAME,
	password: DB_CONFIG.PAYMENT_SERVICE.PASSWORD,
});

const UserPayment = paymentDb.define(...UserPaymentSchema);
const ShopPayment = paymentDb.define(...ShopPaymentSchema);

paymentDb.sync();

module.exports = { UserPayment, ShopPayment };
