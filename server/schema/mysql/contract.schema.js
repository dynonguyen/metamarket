const { DataTypes } = require('../../configs/sequelize');

const ContractSchema = [
	'Contract',
	{
		contractId: {
			type: DataTypes.INTEGER,
			primaryKey: true,
			autoIncrement: true,
		},
		businessLicense: {
			type: DataTypes.STRING(255),
			allowNull: false,
		},
		foodSafetyCertificate: {
			type: DataTypes.STRING(255),
			allowNull: false,
		},
		isOriginCommitment: {
			type: DataTypes.BOOLEAN,
			defaultValue: false,
		},
		isCustomerCareCommitment: {
			type: DataTypes.BOOLEAN,
			defaultValue: false,
		},
		isPolicyCommitment: {
			type: DataTypes.BOOLEAN,
			defaultValue: false,
		},
	},
	{ tableName: 'contracts', timestamps: true, initialAutoIncrement: 1 },
];

module.exports = ContractSchema;
