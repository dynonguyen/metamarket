jQuery(function () {
	const url = new URL(location.href);

	function redirectToPage(page) {
		url.searchParams.set('page', page);
		location.href = url.href;
	}

	$('#firstPageBtn').on('click', function () {
		redirectToPage(1);
	});

	$('#lastPageBtn').on('click', function () {
		const total = Number($(this).attr('data-total'));
		if (!total || isNaN(total)) return;
		redirectToPage(total);
	});

	$('#prevPageBtn').on('click', function () {
		const currentPage = Number($(this).attr('data-page'));
		if (isNaN(currentPage) || currentPage <= 1) return;
		redirectToPage(currentPage - 1);
	});

	$('#nextPageBtn').on('click', function () {
		const currentPage = Number($(this).attr('data-page'));
		if (isNaN(currentPage)) return;
		redirectToPage(currentPage + 1);
	});
});
