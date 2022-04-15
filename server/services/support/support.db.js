const { default: mongoose } = require('mongoose');
const AnonymousShopChatSchema = require('../../schema/mongoose/anonymous-shop-chat.schema');
const AnonymousSysChatSchema = require('../../schema/mongoose/anonymous-sys-chat.schema');
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

const AnonymousShopChat = supportSvcConn.model(
	MONGOOSE_MODEL_NAME.ANO_SHOP_CHAT,
	AnonymousShopChatSchema,
	'anonymousShopChat',
);

const AnonymousSysChat = supportSvcConn.model(
	MONGOOSE_MODEL_NAME.ANO_SYSTEM_CHAT,
	AnonymousSysChatSchema,
	'anonymousSysChat',
);

module.exports = {
	AnonymousShopChat,
	AnonymousSysChat,
	ShopChat,
	SystemChat,
};
