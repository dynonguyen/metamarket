const { DataTypes } = require('../../configs/sequelize');

const ProvinceSchema = [
	'Province',
	{
		provinceId: {
			type: DataTypes.INTEGER,
			primaryKey: true,
		},
		name: {
			type: DataTypes.STRING(50),
			allowNull: false,
		},
		code: {
			type: DataTypes.STRING(5),
			allowNull: false,
		},
	},
	{ tableName: 'provinces', timestamps: false },
];

module.exports = ProvinceSchema;
