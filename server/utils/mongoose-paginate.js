const { default: mongoose } = require('mongoose');
const { DEFAULT } = require('./constants');

const mongoosePaginate = async (
	Model,
	query = {},
	{ pageSize = DEFAULT.PAGE_SIZE, page = 1 },
	options = {
		select: '',
		sort: '',
	},
) => {
	// check if object is mongoose model
	if (Model && Model.prototype instanceof mongoose.Model) {
		[page, pageSize] = [page, pageSize].map(Number);
		const { sort = '', select = '' } = options;
		const promises = [];
		let result = { total: 0, page, pageSize, docs: [] };

		// count documents
		promises.push(
			Model.countDocuments({ ...query }, {}).then(
				(total) => (result.total = total),
			),
		);
		// get data
		promises.push(
			Model.find({ ...query })
				.skip((page - 1) * pageSize)
				.limit(pageSize)
				.select(select)
				.sort(sort)
				.then((data) => (result.docs = data)),
		);

		await Promise.all(promises);
		return result;
	}

	return false;
};

module.exports = {
	mongoosePaginate,
};
