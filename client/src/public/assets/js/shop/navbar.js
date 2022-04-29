const TOGGLE_LS_KEY = 'navbar-toggle';

jQuery(function () {
	const navbar = $('#navbar');
	const main = $('#main');

	// load init navbar status
	const status = localStorage.getItem(TOGGLE_LS_KEY);
	if (status == 'true') {
		navbar.toggle(0);
		main.removeClass('distance-left');
	}

	$('#toggleNavbar').on('click', function () {
		navbar.toggle(150);

		if (main.hasClass('distance-left')) {
			main.removeClass('distance-left');
			localStorage.setItem(TOGGLE_LS_KEY, true);
		} else {
			main.addClass('distance-left');
			localStorage.setItem(TOGGLE_LS_KEY, false);
		}
	});
});
