const { DataTypes } = require('../../configs/sequelize');

const UserAddressSchema = [
	'UserAddress',
	{
		addressId: {
			type: DataTypes.INTEGER,
			primaryKey: true,
			autoIncrement: true,
		},
		detail: {
			type: DataTypes.STRING(100),
			allowNull: false,
		},
		isOfficial: {
			type: DataTypes.BOOLEAN,
			defaultValue: false,
		},
	},
	{ tableName: 'addresses', timestamps: false, initialAutoIncrement: 1 },
];

module.exports = UserAddressSchema;
