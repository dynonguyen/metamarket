const { Catalog } = require('../product.db');
const { MoleculerError } = require('moleculer').Errors;

module.exports = {
	getAllCatalogs: {
		cache: false,

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
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getCatalogByLink: {
		cache: false,

		params: {
			catalogLink: {
				type: 'string',
			},
		},

		async handler(ctx) {
			const { catalogLink } = ctx.params;

			try {
				const catalog = await Catalog.findOne({ link: catalogLink });
				return catalog;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getCatalogNameById: {
		cache: false,
		params: {
			catalogId: 'string',
		},
		async handler(ctx) {
			try {
				const { catalogId } = ctx.params;
				const catalog = await Catalog.findById(catalogId);
				return catalog.name;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
