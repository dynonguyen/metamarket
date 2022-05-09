let starRate = 0;
const MAX_LEN_CONTENT = 500;

jQuery(function () {
	$('.photo-item').on('click', function () {
		$('.photo-item.active').removeClass('active');
		$(this).addClass('active');
		const photoSrc = $(this).find('img').attr('src');
		$('#photoAvt').attr('src', photoSrc.replace('_thumb', ''));
	});

	$('.comment-star').on('mouseenter', function () {
		const star = Number($(this).attr('data-star'));
		starRate = star;
		for (let i = 1; i <= 5; ++i) {
			if (i <= star) {
				$(`.comment-star[data-star="${i}"]`)
					.removeClass('bi-star')
					.addClass('bi-star-fill');
			} else {
				$(`.comment-star[data-star="${i}"]`)
					.removeClass('bi-star-fill')
					.addClass('bi-star');
			}
		}
	});

	$('#commentForm').on('submit', function (e) {
		e.preventDefault();

		const content = $('#commentContent').val().trim();
		if (starRate === 0) {
			return $('#commentError')
				.removeClass('d-none')
				.text('Vui lòng chọn số sao !');
		}
		if (!content) {
			return $('#commentError')
				.removeClass('d-none')
				.text('Vui lòng nhập nội dung !');
		}
		if (content.length > MAX_LEN_CONTENT) {
			return $('#commentError')
				.removeClass('d-none')
				.text(`Nội dung tối đa ${MAX_LEN_CONTENT} ký tự !`);
		}
		$('#commentForm input[name="rate"]').val(starRate);

		this.submit();
	});
});
