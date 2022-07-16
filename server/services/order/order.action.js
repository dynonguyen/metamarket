const {
	ORDER_STATUS,
	PAYMENT_METHOD,
	SVC_NAME,
	DEFAULT,
} = require('../../utils/constants');
const { mongoosePaginate } = require('../../utils/mongoose-paginate');
const { Order } = require('./order.db');
const { MoleculerError } = require('moleculer').Errors;

module.exports = {
	postCreateOrder: {
		params: {
			userId: [{ type: 'number' }, { type: 'string', numeric: true }],
			orderCode: 'string',
			receiverName: 'string',
			receiverPhone: 'string',
			isPayment: 'boolean',
			wardId: [{ type: 'number' }, { type: 'string', numeric: true }],
			addrDetail: 'string',
			products: 'any',
			paymentMethod: [{ type: 'number' }, { type: 'string', numeric: true }],
			transportFee: [{ type: 'number' }, { type: 'string', numeric: true }],
			orderTotal: [{ type: 'number' }, { type: 'string', numeric: true }],
			note: { type: 'string', optional: true, default: '' },
		},
		async handler(ctx) {
			const {
				userId,
				orderCode,
				receiverName,
				receiverPhone,
				isPayment,
				wardId,
				addrDetail,
				products,
				paymentMethod,
				transportFee,
				orderTotal,
				note = '',
			} = ctx.params;

			try {
				const fullAddrStr = await ctx.call(
					`${SVC_NAME.USER}.getFullAddressByWardId`,
					{ wardId },
				);

				let productShops = [];
				products.forEach((p) => {
					const { shopId, ...rest } = p;
					const index = productShops.findIndex((ps) => shopId === ps.shopId);
					if (index === -1) {
						productShops.push({ shopId, products: [rest] });
					} else {
						productShops[index].products.push(rest);
					}
				});

				const promises = [];
				productShops.forEach((ps) => {
					promises.push(
						Order.create({
							userId,
							shopId: ps.shopId,
							orderCode,
							orderDate: new Date(),
							shipperId: -1,
							orderStatus: ORDER_STATUS.PENDING_SHOP,
							deliveryAddress: {
								addrDetail,
								wardId,
								fullAddrStr: `${addrDetail}, ${fullAddrStr}`,
							},
							receiverName,
							receiverPhone,
							products: ps.products,
							paymentMethod,
							isPayment,
							transportFee,
							orderTotal: this.calcTotalByProducts(ps.products),
							note,
						}),
					);
				});

				await Promise.all(promises);
				return true;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getCheckExistByOrderCode: {
		params: {
			orderCode: 'string',
		},
		async handler(ctx) {
			try {
				const order = await Order.findOne({ orderCode: ctx.params.orderCode });
				if (order) {
					return true;
				}
				return false;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getOrderList: {
		cache: false,
		params: {
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
				default: 'orderDate',
			},
			where: {
				type: 'string',
				optional: true,
				default: '',
			},
		},
		async handler(ctx) {
			const { page, pageSize, select, sort, where } = ctx.params;
			let query = {};

			if (where) {
				query = JSON.parse(where);
			}

			try {
				const orderDocs = await mongoosePaginate(
					Order,
					query,
					{ page: Number(page), pageSize: Number(pageSize) },
					{ select, sort },
				);

				return orderDocs;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getUnconfirmedOrderList: {
		cache: false,
		params: {
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
				default: 'orderDate',
			},
			where: {
				type: 'string',
				optional: true,
				default: '',
			},
		},
		async handler(ctx) {
			const { page, pageSize, select, sort, where } = ctx.params;
			let query = { shipperId: -1 }; // Get unconfirmed orders list

			console.log('test unconfirmed order list');

			if (where) {
				query = JSON.parse(where);
			}

			try {
				const orderDocs = await mongoosePaginate(
					Order,
					query,
					{ page: Number(page), pageSize: Number(pageSize) },
					{ select, sort },
				);

				return orderDocs;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getOrderDetailById: {
		cache: false,
		params: {
			orderId: 'string',
		},
		async handler(ctx) {
			const { orderId } = ctx.params;

			try {
				let orderDetail = {};
				const order = await Order.findById(orderId);
				orderDetail = order._doc;

				const promises = [];
				orderDetail.products.forEach((p) => {
					promises.push(
						ctx
							.call(`${SVC_NAME.PRODUCT}.getBasicProductInfoById`, {
								productId: p.productId.toString(),
							})
							.then((product) => (p._doc.name = product.name)),
					);
				});
				promises.push(
					ctx
						.call(`${SVC_NAME.USER}.getUserByUserId`, {
							userId: orderDetail.userId,
						})
						.then((user) => (orderDetail.user = user)),
				);
				await Promise.all(promises);

				return orderDetail;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getCountOrderByShop: {
		cache: false,
		params: {
			shopId: ['number', { type: 'string', numeric: true }],
		},
		async handler(ctx) {
			const { shopId } = ctx.params;
			try {
				const count = await Order.countDocuments({ shopId });
				return count;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getShopRevenue: {
		cache: false,
		params: {
			shopId: ['number', { type: 'string', numeric: true }],
		},
		async handler(ctx) {
			const { shopId } = ctx.params;
			try {
				const orders = await Order.find({ shopId }).select('orderTotal');
				const revenue = orders.reduce((sum, o) => sum + o.orderTotal, 0);
				return revenue;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getShopRevenueByMonth: {
		cache: false,
		params: {
			shopId: ['number', { type: 'string', numeric: true }],
			month: ['number', { type: 'string', numeric: true }],
			year: ['number', { type: 'string', numeric: true }],
		},
		async handler(ctx) {
			const { shopId, month, year } = ctx.params;
			try {
				const orders = await Order.aggregate([
					{
						$addFields: {
							orderMonth: { $month: '$orderDate' },
							orderYear: { $year: '$orderDate' },
						},
					},
					{
						$match: {
							shopId: Number(shopId),
							orderMonth: Number(month),
							orderYear: Number(year),
						},
					},
				]);
				const revenue = orders.reduce((sum, o) => sum + o.orderTotal, 0);
				return revenue;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	putUpdateOrderStatus: {
		params: {
			orderId: 'string',
			status: ['number', { type: 'string', numeric: true }],
		},
		async handler(ctx) {
			const { orderId, status } = ctx.params;
			try {
				await Order.updateOne(
					{ _id: orderId },
					{ orderStatus: Number(status) },
				);
				return true;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	putConfirmOrderShipper: {
		params: {
			orderId: 'string',
			shipperId: ['number', { type: 'string', numeric: true }],
		},
		async handler(ctx) {
			const { orderId, shipperId } = ctx.params;
			try {
				await Order.updateOne(
					{ _id: orderId },
					{ shipperId: Number(shipperId) },
				);
				return true;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
