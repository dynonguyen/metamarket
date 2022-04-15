const { DataTypes } = require('../../configs/sequelize');

const WardSchema = [
	'Ward',
	{
		id: {
			type: DataTypes.INTEGER,
			primaryKey: true,
		},
		name: {
			type: DataTypes.STRING(50),
			allowNull: false,
		},
		prefix: {
			type: DataTypes.STRING(20),
			allowNull: false,
		},
	},
	{ tableName: 'wards', timestamps: false },
];

module.exports = WardSchema;
