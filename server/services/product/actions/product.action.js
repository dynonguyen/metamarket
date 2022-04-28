const { DEFAULT } = require('../../../utils/constants');
const { mongoosePaginate } = require('../../../utils/mongoose-paginate');
const { Product, ProductDetail } = require('../product.db');
const { MoleculerError } = require('moleculer').Errors;
const ObjectID = require('mongoose').Types.ObjectId;

module.exports = {
	getProductWithCatalog: {
		cache: {
			ttl: 5 * 60,
			keys: ['catalogId', 'page', 'pageSize', 'select', 'sort'],
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
			sort: {
				type: 'string',
				optional: true,
				default: '',
			},
		},

		async handler(ctx) {
			let { catalogId, page, pageSize, select, sort } = ctx.params;
			[page, pageSize] = [page, pageSize].map(Number);

			try {
				const productDocs = await mongoosePaginate(
					Product,
					{ catalogId },
					{ pageSize, page },
					{ select, sort },
				);
				return productDocs;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getProductWithCategory: {
		cache: {
			ttl: 5 * 60,
			keys: ['catalogId', 'categoryId', 'page', 'pageSize', 'select', 'sort'],
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
			categoryId: [
				{
					type: 'string',
					numeric: true,
				},
				{
					type: 'number',
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
			sort: {
				type: 'string',
				optional: true,
				default: '',
			},
		},

		async handler(ctx) {
			let { catalogId, categoryId, page, pageSize, select, sort } = ctx.params;
			[page, pageSize] = [page, pageSize].map(Number);

			try {
				const productDocs = await mongoosePaginate(
					Product,
					{ catalogId, categoryId },
					{ pageSize, page },
					{ select, sort },
				);
				return productDocs;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getBasicProductInfoById: {
		cache: {
			ttl: 300,
		},
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
				throw new MoleculerError(error.toString(), 500);
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
				throw new MoleculerError(error.toString(), 500);
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
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	searchProduct: {
		// cache: {
		// 	ttl: 120,
		// 	keys: ['keyword'],
		// },
		params: {
			keyword: {
				type: 'string',
			},
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
			sort: {
				type: 'string',
				optional: true,
				default: '',
			},
			select: {
				type: 'string',
				optional: true,
				default: '_id name price unit stock code avt discount',
			},
		},
		async handler(ctx) {
			let { keyword, page, pageSize, select, sort } = ctx.params;
			[page, pageSize] = [page, pageSize].map(Number);
			keyword = decodeURIComponent(escape(keyword));

			try {
				const productDocs = await mongoosePaginate(
					Product,
					{
						$or: [
							{ name: { $regex: keyword, $options: 'i' } },
							{ code: { $regex: keyword, $options: 'i' } },
						],
					},
					{ page, pageSize },
					{ select, sort },
				);
				return productDocs;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
