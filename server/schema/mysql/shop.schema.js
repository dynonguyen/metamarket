const { DataTypes } = require('../../configs/sequelize');

const ShopSchema = [
	'Shop',
	{
		shopId: {
			type: DataTypes.INTEGER,
			primaryKey: true,
			autoIncrement: true,
		},
		phone: {
			type: DataTypes.STRING(10),
			allowNull: false,
		},
		foundingDate: {
			type: DataTypes.DATE,
			allowNull: false,
		},
		name: {
			type: DataTypes.STRING(100),
			allowNull: false,
		},
		supporterName: {
			type: DataTypes.STRING(50),
			allowNull: false,
		},
		openHours: {
			type: DataTypes.STRING(50),
			allowNull: false,
		},
		logoUrl: {
			type: DataTypes.STRING(255),
			allowNull: true,
		},
	},
	{ tableName: 'shops', timestamps: true, initialAutoIncrement: 1 },
];

module.exports = ShopSchema;
