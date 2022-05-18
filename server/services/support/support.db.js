const { default: mongoose } = require('mongoose');
const ShopChatSchema = require('../../schema/mongoose/shop-chat.schema');
const SystemChatSchema = require('../../schema/mongoose/system-chat.schema');
const { MONGOOSE_MODEL_NAME, DB_CONFIG } = require('../../utils/constants');

const supportSvcConn = mongoose.createConnection(DB_CONFIG.SUPPORT_SERVICE.URL);

const ShopChat = supportSvcConn.model(
	MONGOOSE_MODEL_NAME.SHOP_CHAT,
	ShopChatSchema,
	'shopChat',
);

const SystemChat = supportSvcConn.model(
	MONGOOSE_MODEL_NAME.SYSTEM_CHAT,
	SystemChatSchema,
	'systemChat',
);

module.exports = {
	ShopChat,
	SystemChat,
};
