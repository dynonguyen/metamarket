jQuery(function () {
	$('#keywordInput').on('keydown', function (e) {
		if (e.code === 'Enter') {
			$('#search').click();
		}
	});

	$('#search').on('click', function () {
		const keyword = $('#keywordInput').val().trim();
		if (keyword) {
			window.location.href = `/tim-kiem?keyword=${keyword}`;
		}
	});

	$('#searchshipper').on('click', function () {
		const keyword = $('#keywordInput').val().trim();
		if (keyword) {
			window.location.href = `?keyword=${keyword}`;
		}
	});
});
