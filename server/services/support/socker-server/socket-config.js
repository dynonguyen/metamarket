const { Server: SocketServer } = require('socket.io');

const PORT = Number(process.env.CHAT_SOCKET_PORT) || 4444;
const CLIENT_ORIGIN = process.env.CORS_URL;

const io = new SocketServer(PORT, {
	cors: {
		origin: CLIENT_ORIGIN,
		methods: ['GET', 'POST'],
	},
});

const shopIO = io.of('/shop');

module.exports = {
	shopIO,
};
