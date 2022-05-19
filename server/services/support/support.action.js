const { ShopChat, SystemChat } = require('./support.db');

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
};
