jQuery(function () {
	const catalogItems = $('.catalog-item i.bi');

	catalogItems.on('click', function () {
		const catalogItem = $(this).parents('.catalog-item');

		if ($(this).hasClass('bi-chevron-down')) {
			$(this).removeClass('bi-chevron-down').addClass('bi-chevron-up');
			catalogItem.find('.category-menu').slideDown();
		} else {
			$(this).removeClass('bi-chevron-up').addClass('bi-chevron-down');
			catalogItem.find('.category-menu').slideUp();
		}
	});
});
