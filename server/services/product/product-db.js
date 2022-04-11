const mongoose = require('mongoose');
const ProductSchema = require('../../schema/mongoose/product.schema');
const { DB_URL } = require('../../utils/constants');

const productSvcConn = mongoose.createConnection(DB_URL.PRODUCT_SERVICE);
const ProductModel = productSvcConn.model(
	'ProductModel',
	ProductSchema,
	'products',
);

module.exports = {
	productSvcConn,
	ProductModel,
};
