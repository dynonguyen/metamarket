const { SVC_NAME } = require('../../utils/constants');

module.exports = {
	name: SVC_NAME.AGGREGATE,

	actions: {
		async demo(ctx) {
			const promises = [];
			promises.push(ctx.call('user.demo'));
			promises.push(ctx.call('product.demo'));
			promises.push(ctx.call('order.demo'));
			const data = await Promise.all(promises);

			return 'Kết quả tổng hợp lại nè: ' + data.toString();
		},
	},

	events: {
		'user.call'(ctx) {
			console.log('HOOOOOOOOOOOOOOOOOOOOOOOOOOO');
		},
	},
};
