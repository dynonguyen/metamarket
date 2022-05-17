const MAX = {
	NAME: 100,
	SUPPORTER_NAME: 50,
	OPEN_HOURS: 50,
	EMAIL: 150,
	PASSWORD: 50,
};
const MIN = {
	PASSWORD: 8,
};

const IMG_MAX_SIZE = 2 * 1024 * 1024; // 2 MB

function onShowPassword() {
	$('.password-icon').on('click', function () {
		if ($(this).hasClass('bi-eye-slash-fill')) {
			$(this).removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
			$(this).siblings('input').attr('type', 'text');
		} else {
			$(this).removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
			$(this).siblings('input').attr('type', 'password');
		}
	});
}

function autoTrimInputOnChange() {
	$('input[type="text"], input[type="password"]').on('change', function () {
		$(this).val($(this).val().trim());
	});
}

$.validator.addMethod(
	'regex',
	function (value, element, regexp) {
		const regex = new RegExp(regexp, 'i');
		return this.optional(element) || regex.test(value);
	},
	'Please check your input.',
);
$.validator.addMethod(
	'dateCheck',
	function (value, element) {
		const date = new Date(value).getTime();
		if (date > Date.now()) return false;
		return true;
	},
	'Ngày không hợp lệ',
);
$.validator.addMethod(
	'checkPhoto',
	function (value, element) {
		const imgSize = $(element)[0].files[0].size;
		if (imgSize > IMG_MAX_SIZE) return false;
		return true;
	},
	'Hình ảnh kích thước tối đa 2MB',
);
$.validator.addMethod(
	'policy',
	function (value, element) {
		const isChecked = $(element).is(':checked');
		return isChecked;
	},
	'Vui lòng cam kết chính sách',
);

jQuery(function () {
	onShowPassword();
	autoTrimInputOnChange();

	$('#shopRegisterForm').validate({
		validClass: 'field-valid',
		errorClass: 'field-error',
		errorElement: 'p',

		rules: {
			name: {
				required: true,
				maxlength: MAX.NAME,
			},
			phone: {
				required: true,
				regex: '^0[1-9]d{8}$',
			},
			supporterName: {
				required: true,
				maxlength: MAX.SUPPORTER_NAME,
			},
			openHours: {
				required: true,
				maxlength: MAX.OPEN_HOURS,
			},
			foundingDate: {
				required: true,
				dateCheck: true,
			},
			catalogId: {
				required: true,
				number: true,
			},
			email: {
				required: true,
				email: true,
				maxlength: MAX.EMAIL,
			},
			password: {
				required: true,
				minlength: MIN.PASSWORD,
				maxlength: MAX.PASSWORD,
			},
			businessLicense: {
				required: true,
				checkPhoto: true,
			},
			foodSafetyCertificate: {
				required: true,
				checkPhoto: true,
			},
			isOriginCommitment: {
				policy: true,
			},
			isCustomerCareCommitment: {
				policy: true,
			},
			isPolicyCommitment: {
				policy: true,
			},
		},

		messages: {
			name: {
				required: 'Vui lòng nhập tên cửa hàng',
				maxlength: `Tên cửa hàng tối đa ${MAX.NAME} ký tự`,
			},
			phone: {
				required: 'Vui lòng nhập số điện thoại',
				regex: 'Số điện thoại không hợp lệ',
			},
			supporterName: {
				required: 'Vui lòng nhập họ tên người hỗ trợ',
				maxlength: `Tối đa ${MAX.SUPPORTER_NAME} ký tự`,
			},
			openHours: {
				required: 'Vui lòng nhập thời gian đóng/mở cửa',
				maxlength: `Tối đa ${MAX.OPEN_HOURS} ký tự`,
			},
			foundingDate: {
				required: 'Vui lòng nhập ngày thành lập',
			},
			catalogId: {
				required: 'Vui lòng chọn danh mục sản phẩm',
			},
			email: {
				required: 'Vui lòng nhập email',
				email: 'Email không hợp lệ',
			},
			password: {
				required: 'Vui lòng nhập mật khẩu',
				minlength: `Tối thiểu ${MIN.PASSWORD} ký tự`,
				maxlength: `Tối đa ${MAX.PASSWORD} ký tự`,
			},
			businessLicense: {
				required: 'Vui lòng nhập giấy phép kinh doanh',
			},
			foodSafetyCertificate: {
				required: 'Vui lòng nhập giấy chứng nhận ATTP',
			},
		},

		invalidHandler: function (e, validator) {
			const { errorList } = validator;
			if (errorList) {
				errorList.forEach((item) => {
					$(item.element).addClass('field-error');
				});
			}
		},

		submitHandler: function (form, e) {
			e.preventDefault();

			// form.submit();
		},
	});
});
