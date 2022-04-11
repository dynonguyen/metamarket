const mongoose = require('mongoose');
const ProductSchema = require('../../schema/mongoose/product.schema');
const { DB_CONFIG } = require('../../utils/constants');

const productSvcConn = mongoose.createConnection(DB_CONFIG.PRODUCT_SERVICE.URL);
const ProductModel = productSvcConn.model(
	'ProductModel',
	ProductSchema,
	'products',
);

module.exports = {
	productSvcConn,
	ProductModel,
};
