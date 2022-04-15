const { DataTypes } = require('../../configs/sequelize');
const {
	ACCOUNT_STATUS,
	ADMIN_ACCOUNT_POSITION,
} = require('../../utils/constants');

const AdminAccountSchema = [
	'AdminAccount',
	{
		accountId: {
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
		position: {
			type: DataTypes.SMALLINT,
			allowNull: false,
			defaultValue: ADMIN_ACCOUNT_POSITION.SUPPORTER,
		},
		status: {
			type: DataTypes.SMALLINT,
			allowNull: false,
			defaultValue: ACCOUNT_STATUS.ACTIVE,
		},
	},
	{ tableName: 'adminAccounts', timestamps: true, initialAutoIncrement: 1 },
];

module.exports = AdminAccountSchema;
