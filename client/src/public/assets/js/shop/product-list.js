jQuery(function () {
	const url = new URL(location.href);

	$('#sort').val(sort);
	$('#filter').val(filter);

	$('#sort').on('change', function () {
		const value = $(this).val();
		if (!value) url.searchParams.delete('s');
		else url.searchParams.set('s', value);
		location.href = url.href;
	});

	$('#filter').on('change', function () {
		const value = $(this).val();
		if (!value) {
			url.searchParams.delete('q');
			url.searchParams.delete('f');
		} else {
			let query = {};
			switch (value) {
				case 'exp':
					query = { exp: { $lt: new Date() } };
					break;
				case 'discount':
					query = { discount: { $gt: 0 } };
					break;
				case 'no-discount':
					query = { discount: 0 };
					break;
				case 'no-stock':
					query = { stock: 0 };
					break;
			}
			url.searchParams.set('q', JSON.stringify(query));
			url.searchParams.set('f', value);
		}

		location.href = url.href;
	});
});
