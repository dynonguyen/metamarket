const ApiGateway = require('moleculer-web');
const { SVC_NAME } = require('../../utils/constants');
const routes = require('./routes');

module.exports = {
	name: SVC_NAME.GATEWAY,
	mixins: [ApiGateway],

	settings: {
		port: Number(process.env.GATEWAY_PORT) || 3000,
		routes: routes,
		cors: {
			origin: '*',
			methods: ['GET', 'OPTIONS', 'POST', 'PUT', 'DELETE'],
			allowedHeaders: [],
			exposedHeaders: [],
			credentials: true,
			maxAge: 3600,
		},
	},
};
