const { Catalog } = require('../product.db');
const { MoleculerError } = require('moleculer').Errors;

module.exports = {
	getAllCatalogs: {
		cache: {
			keys: ['select'],
			ttl: 86400, // 1 days
		},

		params: {
			select: {
				type: 'string',
				optional: true,
				default: '',
			},
		},

		async handler(ctx) {
			const { select } = ctx.params;
			try {
				const catalogs = await Catalog.find({}).select(select);
				return catalogs;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getCatalogIdByLink: {
		cache: {
			ttl: 86400,
			keys: ['catalogLink'],
		},

		params: {
			catalogLink: {
				type: 'string',
			},
		},

		async handler(ctx) {
			const { catalogLink } = ctx.params;

			try {
				const catalogId = await Catalog.findOne({ link: catalogLink }).select(
					'_id',
				);
				return catalogId._id;
			} catch (error) {
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
