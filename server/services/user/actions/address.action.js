const { MoleculerError } = require('moleculer').Errors;
const { Sequelize } = require('sequelize');
const { Province, District, Ward } = require('../user.db');

module.exports = {
	getAllProvinces: {
		cache: {
			ttl: 86400,
		},
		async handler(ctx) {
			try {
				const provinces = await Province.findAll({ raw: true });
				return provinces;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getDistrictsByProvinceId: {
		cache: {
			ttl: 86400,
			keys: ['provinceId'],
		},
		params: {
			provinceId: [{ type: 'number' }, { type: 'string', numeric: true }],
		},
		async handler(ctx) {
			try {
				const districts = await District.findAll({
					raw: true,
					where: { provinceId: Number(ctx.params.provinceId) },
					attributes: { exclude: ['provinceId'] },
				});
				return districts;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getWardsByDistrictId: {
		cache: {
			ttl: 86400,
			keys: ['districtId'],
		},
		params: {
			districtId: [{ type: 'number' }, { type: 'string', numeric: true }],
		},
		async handler(ctx) {
			try {
				const wards = await Ward.findAll({
					raw: true,
					where: { districtId: Number(ctx.params.districtId) },
					attributes: { exclude: ['districtId'] },
				});
				return wards;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getFullAddressByWardId: {
		cache: {
			ttl: 300,
			keys: ['wardId'],
		},
		params: {
			wardId: [{ type: 'number' }, { type: 'string', numeric: true }],
		},
		async handler(ctx) {
			try {
				const address = await Ward.findOne({
					raw: true,
					where: { wardId: ctx.params.wardId },
					attributes: [
						'prefix',
						'name',
						[Sequelize.col('District.name'), 'districtName'],
						[Sequelize.col('District.prefix'), 'districtPrefix'],
						[Sequelize.col('District.Province.name'), 'province'],
					],
					include: {
						model: District,
						attributes: [],
						include: {
							attributes: [],
							model: Province,
						},
					},
				});

				if (address) {
					const { name, prefix, province, districtName, districtPrefix } =
						address;
					return `${prefix} ${name}, ${districtPrefix} ${districtName}, ${province}`;
				}

				return '';
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
