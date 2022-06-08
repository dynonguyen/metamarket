const { MoleculerError } = require('moleculer').Errors;
const { SVC_NAME } = require('../../utils/constants');
const { Shipper, AdminAccount } = require('./internal.db');
const { Op } = require('sequelize');
module.exports = {
	name: SVC_NAME.INTERNAL,

	actions: {
		getAccountByUsername: {
			cache: false,

			params: {
				username: 'string',
			},

			async handler(ctx) {
				const { username } = ctx.params;
				try {
					const adminAccount = await AdminAccount.findOne({
						raw: true,
						where: {
							username,
						},
					});
					if (adminAccount) {
						return adminAccount;
					}
					return null;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		getShipperByUsername: {
			cache: false,

			params: {
				username: 'string',
			},

			async handler(ctx) {
				const { username } = ctx.params;
				try {
					const shipper = await Shipper.findOne({
						raw: true,
						where: {
							username,
						},
					});
					if (shipper) {
						return shipper;
					}
					return null;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		getAdminById: {
			cache: false,

			params: {
				accountId: [{ type: 'number' }, { type: 'string', numeric: true }],
			},

			async handler(ctx) {
				const { accountId } = ctx.params;
				try {
					const admin = await AdminAccount.findOne({
						raw: true,
						where: {
							accountId,
						},
					});
					if (admin) {
						return admin;
					}
					return null;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		getShipperById: {
			cache: false,

			params: {
				shipperId: [{ type: 'number' }, { type: 'string', numeric: true }],
			},

			async handler(ctx) {
				const { shipperId } = ctx.params;
				try {
					const shipper = await Shipper.findOne({
						raw: true,
						where: {
							shipperId,
						},
					});
					if (shipper) {
						return shipper;
					}
					return null;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		//tim kiem shipper theo ten
		searchShipper: {
			cache: false,

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
					default: '10',
				},
			},

			async handler(ctx) {
				let { keyword, page, pageSize } = ctx.params;
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
							'address',
							'peopleId',
							'driverLicense',
							'status',
						],
					});
					if (result) return result;
					return null;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		//update trang thai shipper
		updateStatusShpper: {
			cache: false,
			params: {
				shipperid: [{ type: 'number' }, { type: 'string', numeric: true }],
				status: [{ type: 'number' }, { type: 'string', numeric: true }],
			},
			async handler(ctx) {
				const { shipperid, status } = ctx.params;
				try {
					const result = await Shipper.update(
						{ status: status },
						{ where: { shipperId: shipperid } },
					);
					return result;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		// update dia chi cua shipper
		updateAddressShiper: {
			cache: false,
			params: {
				shipperid: [{ type: 'number' }, { type: 'string', numeric: true }],
				address: 'string',
			},
			async handler(ctx) {
				let { shipperid, address } = ctx.params;
				address = decodeURIComponent(escape(address));
				try {
					const result = await Shipper.update(
						{ address: address },
						{ where: { shipperId: shipperid } },
					);
					return result;
				} catch (error) {
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		// update giay phep lai xe shipper
		updateDriverLicense: {
			cache: false,
			params: {
				shipperid: [{ type: 'number' }, { type: 'string', numeric: true }],
				driverlicense: 'string',
			},
			async handler(ctx) {
				const { shipperid, driverlicense } = ctx.params;
				try {
					const result = await Shipper.update(
						{ driverLicense: driverlicense },
						{ where: { shipperId: shipperid } },
					);
					return result;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		//lay tat ca shipper
		getAllShipper: {
			caches: false,
			params: {
				keyword: {
					type: 'string',
					default: '',
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
					default: '10', // them default pagesize
				},
			},
			async handler(ctx) {
				let { page, pageSize, keyword } = ctx.params;
				keyword = decodeURIComponent(escape(keyword));
				page = Number(ctx.params.page);
				pageSize = Number(ctx.params.pageSize);
				try {
					const result = await Shipper.findAndCountAll({
						limit: pageSize,
						offset: (page - 1) * pageSize,
						where: { username: { [Op.like]: '%' + keyword + '%' } },
						attributes: [
							'shipperId',
							'username',
							'address',
							'peopleId',
							'driverLicense',
							'status',
						],
					});
					if (result) return { result, page, pagesize: pageSize };
					return null;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},

		//tao moi 1 shipper
		addNewShipper: {
			cache: false,
			params: {
				username: 'string',
				password: {
					type: 'string',
					default: '123',
				},
				peopleId: 'string',
				address: 'string',
				driverLicense: 'string',
			},
			async handler(ctx) {
				let { username, peopleId, address, driverLicense, password } =
					ctx.params;
				try {
					const result = await Shipper.create({
						username: username,
						password: password,
						peopleId: peopleId,
						address: address,
						driverLicense: driverLicense,
					});
					return result;
				} catch (error) {
					this.logger.error(error);
					throw new MoleculerError(error.toString(), 500);
				}
			},
		},
	},
};
