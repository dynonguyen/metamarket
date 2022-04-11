const { DataTypes } = require('../../configs/sequelize');

const UserSchema = [
	'User',
	{
		userId: {
			type: DataTypes.INTEGER,
			primaryKey: true,
			autoIncrement: true,
		},
		fullname: {
			type: DataTypes.STRING(50),
			allowNull: false,
		},
		peopleId: {
			type: DataTypes.STRING(12),
			allowNull: true,
		},
		DOB: {
			type: DataTypes.DATE,
			allowNull: true,
		},
	},
	{ tableName: 'users', timestamps: true, initialAutoIncrement: 1000 },
];

module.exports = UserSchema;
