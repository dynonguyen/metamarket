const { DataTypes } = require('../../configs/sequelize');
const { ACCOUNT_STATUS } = require('../../utils/constants');

const ShipperSchema = [
	'Shipper',
	{
		shipperId: {
			type: DataTypes.INTEGER,
			primaryKey: true,
			autoIncrement: true,
		},
		username: {
			type: DataTypes.STRING(20),
			unique: true,
			allowNull: false,
		},
		password: {
			type: DataTypes.STRING(72),
			allowNull: false,
		},
		peopleId: {
			type: DataTypes.STRING(12),
			allowNull: false,
		},
		address: {
			type: DataTypes.STRING(255),
			allowNull: false,
		},
		driverLicense: {
			type: DataTypes.STRING(255),
			allowNull: false,
		},
		status: {
			type: DataTypes.SMALLINT,
			allowNull: false,
			defaultValue: ACCOUNT_STATUS.ACTIVE,
		},
	},
	{ tableName: 'shippers', timestamps: true, initialAutoIncrement: 1 },
];

module.exports = ShipperSchema;
