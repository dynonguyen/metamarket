jQuery(function () {
	$('.photo-item').on('click', function () {
		$('.photo-item.active').removeClass('active');
		$(this).addClass('active');
		const photoSrc = $(this).find('img').attr('src');
		$('#photoAvt').attr('src', photoSrc.replace('_thumb', ''));
	});
});
