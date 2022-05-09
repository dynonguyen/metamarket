jQuery(function () {
	$('#form').on('submit', function (e) {
		e.preventDefault();

		const password = $('#password').val().trim();
		const confirmPassword = $('#confirmPassword').val().trim();

		if (password && password !== confirmPassword) {
			$('#error').removeClass('d-none').text('Mật khẩu không trùng khớp');
			return;
		}

		e.currentTarget.submit();
	});
});
