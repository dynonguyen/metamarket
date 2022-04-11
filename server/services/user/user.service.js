const { SVC_NAME } = require("../../utils/constants");
const { UserModel } = require("./user-db");

module.exports = {
	name: SVC_NAME.USER,

	actions: {
		list: {
			cache: false,

			async handler(ctx) {
				const users = await UserModel.find({});
				return [];
			},
		},
	},
};
