const { Category, Catalog } = require('../product.db');

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

	getAllCategories: {
		cache: false,

		async handler(ctx) {
			try {
				const categories = await Category.find({});
				return categories;
			} catch (error) {
				this.logger.error(error);
				return [];
			}
		},
	},

	getCatalogWithCategory: {
		cache: {
			ttl: 86400, // 1 day
		},

		async handler(ctx) {
			try {
				console.log('Hello');
				const catalogs = await this.actions.getAllCatalogs();
				const result = [];

				const promises = [];
				catalogs.forEach((catalog) => {
					promises.push(
						Category.find({ catalogId: catalog._id })
							.select('-_id -catalogId')
							.then((categories) => {
								result.push({
									name: catalog.name,
									link: catalog.link,
									categories,
								});
							}),
					);
				});
				await Promise.all(promises);

				return result;
			} catch (error) {
				this.logger.error(error);
				return [];
			}
		},
	},
};
