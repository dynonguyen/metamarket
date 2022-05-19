const { DataTypes } = require('../../configs/sequelize');

const DistrictSchema = [
	'District',
	{
		districtId: {
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
	{ tableName: 'districts', timestamps: false },
];

module.exports = DistrictSchema;
