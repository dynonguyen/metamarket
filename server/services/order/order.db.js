const mongoose = require('mongoose');
const OrderSchema = require('../../schema/mongoose/order.schema');
const { DB_CONFIG, MONGOOSE_MODEL_NAME } = require('../../utils/constants');

const orderSvcConn = mongoose.createConnection(DB_CONFIG.ORDER_SERVICE.URL);
const Order = orderSvcConn.model(
	MONGOOSE_MODEL_NAME.ORDER,
	OrderSchema,
	'orders',
);

module.exports = { orderSvcConn, Order };
