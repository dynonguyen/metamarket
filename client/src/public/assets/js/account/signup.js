const MAX_LEN_EMAIL = 150;
const MAX_LEN_FULLNAME = 50;
const MIN_LEN_PASSWORD = 6;
const MAX_LEN_PASSWORD = 100;

function showFormError(msg = '') {
	$('#formError').html(msg).removeClass('d-none');
}

jQuery(function () {
	$('#form').on('submit', function (e) {
		e.preventDefault();
		const email = $('#email').val()?.trim();
		const fullname = $('#fullname').val()?.trim();
		const password = $('#password').val()?.trim();
		const confirmPwd = $('#confirmPwd').val()?.trim();

		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

		if (!emailRegex.test(email)) {
			return showFormError('Email không hợp lệ !');
		}

		if (email.length > MAX_LEN_EMAIL) {
			return showFormError(`Email tối đa ${MAX_LEN_EMAIL} ký tự !`);
		}

		if (!fullname) {
			return showFormError('Vui lòng nhập họ tên !');
		}

		if (fullname.length > MAX_LEN_FULLNAME) {
			return showFormError(`Họ tên tối đa ${MAX_LEN_FULLNAME} ký tự`);
		}

		if (!password) {
			return showFormError('Vui lòng nhập mật khẩu !');
		}

		if (
			password.length < MIN_LEN_PASSWORD ||
			password.length > MAX_LEN_PASSWORD
		) {
			return showFormError(
				`Mật khẩu ít nhất ${MIN_LEN_PASSWORD}, nhiều nhất ${MAX_LEN_PASSWORD} ký tự !`,
			);
		}

		$('#formError').addClass('d-none');

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
