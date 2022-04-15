const { DataTypes } = require('../../configs/sequelize');

const UserSchema = [
	'User',
	{
		userId: {
			type: DataTypes.INTEGER,
			primaryKey: true,
			autoIncrement: true,
		},
		phone: {
			type: DataTypes.STRING(10),
			allowNull: true,
			unique: true,
		},
		fullname: {
			type: DataTypes.STRING(50),
			allowNull: false,
		},
		gender: {
			type: DataTypes.BOOLEAN,
			defaultValue: true,
		},
		dbo: {
			type: DataTypes.DATE,
			allowNull: true,
			defaultValue: new Date('1970-01-01'),
		},
	},
	{ tableName: 'users', timestamps: true, initialAutoIncrement: 1 },
];

module.exports = UserSchema;
