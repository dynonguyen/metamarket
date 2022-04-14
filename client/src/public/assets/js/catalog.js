jQuery(function () {
	const catalogItems = $('.catalog-item');

	catalogItems.on('mouseover', function () {
		$(this)
			.find('i.bi')
			.removeClass('bi-chevron-down')
			.addClass('bi-chevron-up');
		$(this).find('.category-menu').slideDown(75);
	});

	catalogItems.on('mouseleave', function () {
		$(this)
			.find('i.bi')
			.removeClass('bi-chevron-up')
			.addClass('bi-chevron-down');
		$(this).find('.category-menu').slideUp(75);
	});
});
