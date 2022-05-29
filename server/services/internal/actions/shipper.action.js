const { DEFAULT } = require('../../../utils/constants');
const { Shipper } = require('../internal.db');
const { Op } = require('sequelize');
const { MoleculerError } = require('moleculer').Errors;
// const bcrypt = require('bcrypt');
module.exports = {
	getAllShipper: {
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
		},
		async handler(ctx) {
			let { page, pageSize } = ctx.params;
			[page, pageSize] = [page, pageSize].map(Number);
			try {
				const result = await Shipper.findAll({
					limit: pageSize,
					offset: (page - 1) * pageSize,
					attributes: [
						'shipperId',
						'username',
						'peopleId',
						'address',
						'driverLicense',
						'status',
					],
				});
				return result;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
	getShipperById: {
		params: {
			shipperid: [
				{ type: 'number', min: 0 },
				{ type: 'string', numeric: true },
			],
		},
		async handler(ctx) {
			let { shipperid } = ctx.params;
			//shipperid = decodeURIComponent(escape(shipperid));
			[shipperid] = [shipperid].map(Number);
			try {
				const result = await Shipper.findOne({
					where: { shipperId: { [Op.eq]: shipperid } },
					attributes: [
						'shipperId',
						'username',
						'peopleId',
						'address',
						'driverLicense',
						'status',
					],
				});
				return result;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
	searchShipper: {
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
				default: DEFAULT.PAGE_SIZE_SHIPPER.toString(),
			},
		},
		async handler(ctx) {
			let { keyword, page, pageSize, select } = ctx.params;
			[page, pageSize] = [page, pageSize].map(Number);
			keyword = decodeURIComponent(escape(keyword));
			try {
				const result = await Shipper.findAll({
					limit: pageSize,
					offset: (page - 1) * pageSize,
					where: { username: { [Op.like]: '%' + keyword + '%' } },
					attributes: [
						'shipperId',
						'username',
						'peopleId',
						'address',
						'driverLicense',
						'status',
					],
				});
				return result;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
	updateShipperStatus: {
		params: {
			shipperid: [
				{ type: 'number', min: 0 },
				{ type: 'string', numeric: true },
			],
			status: [
				{ type: 'number', min: 0 },
				{ type: 'string', numeric: true },
			],
		},
		async handler(ctx) {
			let { shipperid, status } = ctx.params;
			shipperid = Number(ctx.params.shipperid);
			status = Number(ctx.params.status);
			try {
				const result = Shipper.update(
					{ status: status },
					{ where: { shipperId: shipperid } },
				);
				return result;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
	// addNewShipper: {
	// 	params: {
	// 		shipperid: [
	// 			{ type: 'number', min: 0 },
	// 			{ type: 'string', numeric: true },
	// 		],
	// 		username: 'string',
	// 		peopleid: 'string',
	// 		address: 'string',
	// 		driverlicense: 'string',
	// 	},
	// 	async handler(ctx) {
	// 		let { shipperid, username, peopleid, address, driverlicense } =
	// 			ctx.params;
	// 		shipperid = Number(ctx.params.shipperid);
	// 		const password = bcrypt.hashSync(DEFAULT.SHIPPER_PASSWORD, 10);
	// 		try {
	// 			const result = await Shipper.create({
	// 				shipperId: shipperid,
	// 				username: username,
	// 				password: password,
	// 				peopleId: peopleid,
	// 				address: address,
	// 				driverLicense: driverlicense,
	// 			});
	// 			return result;
	// 		} catch (error) {
	// 			throw new MoleculerError(error.toString(), 500);
	// 		}
	// 	},
	// },
};
