jQuery(function () {
	const bodyHeight = $('body').height();

	const observer = new IntersectionObserver(
		function (entries) {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					$('#scrollTop').show(200);
				} else {
					$('#scrollTop').hide(200);
				}
			});
		},
		{
			rootMargin: `0px 0px ${bodyHeight - 1500}px 0px`,
		},
	);

	observer.observe(document.getElementById('footer'));

	$('#scrollTop').on('click', function () {
		$('html, body').animate({ scrollTop: 0 }, 450);
		$(this).hide(200);
	});
});
