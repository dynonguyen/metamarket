const { sequelizeConnect } = require('../../configs/sequelize');
const AccountSchema = require('../../schema/mysql/account.schema');
const UserAddressSchema = require('../../schema/mysql/address.schema');
const ContractSchema = require('../../schema/mysql/contract.schema');
const DistrictSchema = require('../../schema/mysql/district.schema');
const ProvinceSchema = require('../../schema/mysql/province.schema');
const ShopSchema = require('../../schema/mysql/shop.schema');
const UserSchema = require('../../schema/mysql/user.schema');
const WardSchema = require('../../schema/mysql/ward.schema');
const { DB_CONFIG } = require('../../utils/constants');

// ------ Create a connection
const userDb = sequelizeConnect({
	dbName: DB_CONFIG.USER_SERVICE.DB_NAME,
	hostname: DB_CONFIG.USER_SERVICE.HOSTNAME,
	dialect: 'mysql',
	username: DB_CONFIG.USER_SERVICE.USERNAME,
	password: DB_CONFIG.USER_SERVICE.PASSWORD,
});

// ------ Create models
const User = userDb.define(...UserSchema);
const Account = userDb.define(...AccountSchema);
const Shop = userDb.define(...ShopSchema);
const UserAddress = userDb.define(...UserAddressSchema);
const Province = userDb.define(...ProvinceSchema);
const District = userDb.define(...DistrictSchema);
const Ward = userDb.define(...WardSchema);
const Contract = userDb.define(...ContractSchema);

// ------ Foreign Key
// account vs user (1-1)
Account.hasOne(User, {
	sourceKey: 'accountId',
	foreignKey: {
		name: 'accountId',
		allowNull: false,
	},
	onDelete: 'RESTRICT',
	onUpdate: 'RESTRICT',
});
User.belongsTo(Account, { foreignKey: 'accountId' });

// user vs address (1-n)
User.hasMany(UserAddress, {
	sourceKey: 'userId',
	foreignKey: {
		name: 'ownerId',
		allowNull: false,
	},
	onDelete: 'CASCADE',
	onUpdate: 'CASCADE',
});
UserAddress.belongsTo(User, {
	foreignKey: 'ownerId',
});

// province vs district (1-n)
Province.hasMany(District, {
	sourceKey: 'id',
	foreignKey: 'provinceId',
});
District.belongsTo(Province, { foreignKey: 'provinceId' });

// district vs wards (1-n)
District.hasMany(Ward, {
	sourceKey: 'id',
	foreignKey: 'districtId',
});
Ward.belongsTo(District, { foreignKey: 'districtId' });

// ward vs address (1-n)
Ward.hasMany(UserAddress, {
	sourceKey: 'id',
	foreignKey: 'wardId',
});
UserAddress.belongsTo(Ward, { foreignKey: 'wardId' });

// shop vs account (1-1)
Account.hasOne(Shop, {
	sourceKey: 'accountId',
	foreignKey: {
		name: 'accountId',
		allowNull: false,
	},
	onDelete: 'RESTRICT',
	onUpdate: 'RESTRICT',
});
Shop.belongsTo(Account, { foreignKey: 'accountId' });

// contract vs shop (1-1)
Shop.hasOne(Contract, {
	sourceKey: 'shopId',
	foreignKey: {
		name: 'shopId',
		allowNull: false,
	},
});
Contract.belongsTo(Shop, { foreignKey: 'shopId' });

// ------ Sync database
userDb.sync({alter:true});

module.exports = {
	Account,
	Contract,
	District,
	Province,
	Shop,
	User,
	UserAddress,
	Ward,
};
