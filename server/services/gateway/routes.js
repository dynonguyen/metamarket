const { SVC_NAME } = require('../../utils/constants');
const USER_SVC = SVC_NAME.USER;
const PRODUCT_SVC = SVC_NAME.PRODUCT;

module.exports = [
	{
		path: '/api/v1',
		whitelist: ['**'],
		authentication: false,
		autoAliases: false,
		mergeParams: true,

		bodyParsers: {
			json: true,
			urlencoded: { extended: true },
		},

		aliases: {
			// User service
			'GET users/list': `${USER_SVC}.list`,

			// Product service
			'GET products/list': `${PRODUCT_SVC}.list`,
			'GET products/by-name': `${PRODUCT_SVC}.getProductByName`,
		},
	},
];
