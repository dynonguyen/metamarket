const { Catalog } = require('../product.db');

module.exports = {
	getAllCatalogs: {
		cache: false,

		async handler(ctx) {
			try {
				const catalogs = await Catalog.find({});
				return catalogs;
			} catch (error) {
				this.logger.error(error);
				return [];
			}
		},
	},
};
