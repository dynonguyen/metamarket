const { DataTypes } = require('../../configs/sequelize');
const { ACCOUNT_STATUS, ACCOUNT_TYPE } = require('../../utils/constants');

const AccountSchema = [
	'Account',
	{
		accountId: {
			type: DataTypes.INTEGER,
			primaryKey: true,
			autoIncrement: true,
		},
		email: {
			type: DataTypes.STRING(150),
			allowNull: false,
			unique: true,
		},
		type: {
			type: DataTypes.SMALLINT,
			allowNull: false,
			default: ACCOUNT_TYPE.CUSTOMER,
		},
		password: {
			type: DataTypes.STRING(72),
			allowNull: true,
		},
		googleId: {
			type: DataTypes.STRING(255),
			allowNull: true,
		},
		status: {
			type: DataTypes.SMALLINT,
			defaultValue: ACCOUNT_STATUS.WAITING_APPROVAL,
		},
	},
	{ tableName: 'accounts', timestamps: true, initialAutoIncrement: 1 },
];

module.exports = AccountSchema;
