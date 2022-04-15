const mongoose = require('mongoose');
const CatalogSchema = require('../../schema/mongoose/catalog.schema');
const CategorySchema = require('../../schema/mongoose/category.schema');
const ProductDetailSchema = require('../../schema/mongoose/product-detail.schema');
const ProductSchema = require('../../schema/mongoose/product.schema');
const { DB_CONFIG, MONGOOSE_MODEL_NAME } = require('../../utils/constants');

const productSvcConn = mongoose.createConnection(DB_CONFIG.PRODUCT_SERVICE.URL);

// Create models
const Catalog = productSvcConn.model(
	MONGOOSE_MODEL_NAME.CATALOG,
	CatalogSchema,
	'catalogs',
);

const Category = productSvcConn.model(
	MONGOOSE_MODEL_NAME.CATEGORY,
	CategorySchema,
	'categories',
);

const Product = productSvcConn.model(
	MONGOOSE_MODEL_NAME.PRODUCT,
	ProductSchema,
	'products',
);

const ProductDetail = productSvcConn.model(
	MONGOOSE_MODEL_NAME.PRODUCT_DETAIL,
	ProductDetailSchema,
	'productDetails',
);

module.exports = {
	Catalog,
	Category,
	Product,
	ProductDetail,
	productSvcConn,
};
