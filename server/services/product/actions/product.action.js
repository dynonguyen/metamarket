const { DEFAULT } = require('../../../utils/constants');
const { mongoosePaginate } = require('../../../utils/mongoose-paginate');
const { Product, ProductDetail } = require('../product.db');
const { MoleculerError } = require('moleculer').Errors;
const ObjectID = require('mongoose').Types.ObjectId;

module.exports = {
	getProductWithCatalog: {
		cache: {
			ttl: 5 * 60,
			keys: ['catalogId', 'page', 'pageSize', 'select'],
		},

		params: {
			catalogId: [
				{
					type: 'string',
					length: 24,
				},
				{
					type: 'objectID',
					ObjectID,
				},
			],
			page: {
				type: 'string',
				numeric: true,
				min: '1',
				default: '1',
			},
			pageSize: {
				type: 'string',
				numeric: true,
				min: '1',
				default: DEFAULT.PAGE_SIZE.toString(),
			},
			select: {
				type: 'string',
				optional: true,
				default: '',
			},
		},

		async handler(ctx) {
			let { catalogId, page, pageSize, select } = ctx.params;
			[page, pageSize] = [page, pageSize].map(Number);

			try {
				const productDocs = await mongoosePaginate(
					Product,
					{ catalogId },
					{ pageSize, page },
					{ select },
				);
				return productDocs;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getBasicProductInfoById: {
		cache: false,
		params: {
			productId: {
				type: 'string',
				length: 24,
			},
		},

		async handler(ctx) {
			try {
				const { productId } = ctx.params;
				const product = await Product.findById(productId).populate({
					path: 'catalogId',
					select: '-categories',
				});
				return product;
			} catch (error) {
				this.logger.error(error);
				return null;
			}
		},
	},

	getProductDetailById: {
		cache: false,
		params: {
			productId: {
				type: 'string',
				length: 24,
			},
		},
		async handler(ctx) {
			try {
				const { productId } = ctx.params;
				const productDetail = await ProductDetail.findOne({ productId });
				return productDetail;
			} catch (error) {
				this.logger.error(error);
				return null;
			}
		},
	},

	getProductByShopId: {
		cache: false,
		params: {
			shopId: [{ type: 'string', numeric: true }, { type: 'number' }],
			limit: [{ type: 'number', default: 8 }],
			select: {
				type: 'string',
				optional: true,
				default: '',
			},
		},
		async handler(ctx) {
			try {
				const shopId = Number(ctx.params.shopId);
				const { limit, select } = ctx.params;

				const products = await Product.find({ shopId })
					.skip(0)
					.limit(limit)
					.select(select);

				return products;
			} catch (error) {
				this.logger.error(error);
				return null;
			}
		},
	},
};
