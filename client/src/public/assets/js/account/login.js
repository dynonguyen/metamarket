const MAX_LEN_EMAIL = 150;
const MAX_LEN_PASSWORD = 100;

function showFormError(msg = '') {
	$('#formError').html(msg).removeClass('d-none');
}

jQuery(function () {
	$('#form').on('submit', function (e) {
		e.preventDefault();

		const email = $('#email').val()?.trim();
		const password = $('#password').val()?.trim();

		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

		if (!emailRegex.test(email)) {
			return showFormError('Email không hợp lệ !');
		}

		if (email.length > MAX_LEN_EMAIL) {
			return showFormError(`Email tối đa ${MAX_LEN_EMAIL} ký tự !`);
		}

		if (!password) {
			return showFormError('Vui lòng nhập mật khẩu !');
		}

		if (password.length > MAX_LEN_PASSWORD) {
			return showFormError(`Mật khẩu tối đa ${MAX_LEN_PASSWORD} ký tự !`);
		}

		this.submit();
	});

	$('.password-icon').on('click', function () {
		if ($(this).hasClass('bi-eye-slash-fill')) {
			$(this).removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
			$(this).siblings('input').attr('type', 'text');
		} else {
			$(this).removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
			$(this).siblings('input').attr('type', 'password');
		}
	});
});
