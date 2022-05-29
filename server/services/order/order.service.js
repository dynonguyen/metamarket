const { SVC_NAME } = require('../../utils/constants');
const orderActions = require('./order.action');

module.exports = {
	name: SVC_NAME.ORDER,
	actions: {
		...orderActions,
	},
	methods: {
		calcTotalByProducts(products = []) {
			return products.reduce((total, product) => {
				const { quantity, price, discount } = product;
				return total + (quantity * price * (100 - discount)) / 100;
			}, 0);
		},
	},
};
