const { DataTypes } = require('../../configs/sequelize');

const UserPaymentSchema = [
	'UserPayment',
	{
		paymentId: {
			type: DataTypes.INTEGER,
			primaryKey: true,
			autoIncrement: true,
		},
		userId: {
			type: DataTypes.INTEGER,
			allowNull: false,
		},
		orderId: {
			type: DataTypes.STRING(24),
			allowNull: false,
		},
		paymentType: {
			type: DataTypes.SMALLINT,
			allowNull: false,
		},
		transactionCode: {
			type: DataTypes.STRING(20),
			allowNull: true,
			defaultValue: '',
		},
		totalMoney: {
			type: DataTypes.INTEGER,
			allowNull: false,
			defaultValue: 0,
			validate: {
				min: 0,
			},
		},
		note: {
			type: DataTypes.STRING(255),
			allowNull: true,
			defaultValue: '',
		},
	},
	{ tableName: 'userPayments', timestamps: true, initialAutoIncrement: 1 },
];

module.exports = UserPaymentSchema;
