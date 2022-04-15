const { DataTypes } = require('../../configs/sequelize');

const ShopPaymentSchema = [
	'ShopPayment',
	{
		paymentId: {
			type: DataTypes.INTEGER,
			primaryKey: true,
			autoIncrement: true,
		},
		shopId: {
			type: DataTypes.INTEGER,
			allowNull: false,
		},
		orderId: {
			type: DataTypes.STRING(24),
			allowNull: false,
		},
		commissionRate: {
			type: DataTypes.FLOAT,
			allowNull: false,
		},
		commissionMoney: {
			type: DataTypes.INTEGER,
			allowNull: false,
		},
		totalMoney: {
			type: DataTypes.INTEGER,
			allowNull: false,
			defaultValue: 0,
			validate: {
				min: 0,
			},
		},
	},
	{ tableName: 'shopPayments', timestamps: true, initialAutoIncrement: 1 },
];

module.exports = ShopPaymentSchema;
