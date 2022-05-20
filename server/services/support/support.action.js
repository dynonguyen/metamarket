const { SVC_NAME } = require('../../utils/constants');
const { ShopChat, SystemChat } = require('./support.db');
const { MoleculerError } = require('moleculer').Errors;

module.exports = {
	getShopChatHistory: {
		params: {
			shopId: [{ type: 'number' }, { type: 'string', numeric: true }],
			userId: [{ type: 'number' }, { type: 'string', numeric: true }],
		},
		async handler(ctx) {
			const { userId, shopId } = ctx.params;

			try {
				const chatHistory = await ShopChat.findOne({ userId, shopId });
				if (chatHistory) {
					return chatHistory.history;
				}
				return [];
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},

	getLastChatsByShopId: {
		cache: false,
		params: {
			shopId: [{ type: 'number' }, { type: 'string', numeric: true }],
		},
		async handler(ctx) {
			const { shopId } = ctx.params;

			try {
				const promises = [];
				const result = [];

				const chats = await ShopChat.find(
					{ shopId },
					{ userId: 1, history: { $slice: -1 } },
				);

				const len = chats.length;

				for (let i = 0; i < len; ++i) {
					promises.push(
						ctx
							.call(`${SVC_NAME.USER}.getUserByUserId`, {
								userId: chats[i].userId,
							})
							.then((user) => {
								result.push({ message: chats[i].history[0], user });
							}),
					);
				}

				await Promise.all(promises);
				return result;
			} catch (error) {
				this.logger.error(error);
				throw new MoleculerError(error.toString(), 500);
			}
		},
	},
};
