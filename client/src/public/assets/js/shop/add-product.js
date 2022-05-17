const IMG_MAX_SIZE = 2 * 1024 * 1024; // 2 MB
const MAX_PHOTOS_LEN = 10;
let infosLen = 0;

const staticUrl =
	typeof STATIC_FILE_URL !== 'undefined' ? STATIC_FILE_URL : '/public';

function loadNicEditor() {
	bkLib.onDomLoaded(function () {
		new nicEditor({
			iconsPath: `${staticUrl}/vendors/nicEdit/nicEditorIcons.gif`,
		}).panelInstance('desc');
		$('.nicEdit-main').parent('div').css({ width: '100%', padding: '8px' });
		$('.nicEdit-panelContain').parent('div').css({ width: '100%' });
	});
}

function onRemoveOtherInfoInput() {
	$('.remove-other-info').on('click', function () {
		console.log($(this).parent('div'));
		$(this).parent('.form-label').parent('div').remove();
	});
}

function renderOtherInfoInput() {
	const xml = `<div class='col col-12 col-md-4 col-lg-3'>
							<label class='form-label'>Thông tin khác <i class='bi bi-trash-fill cursor-pointer remove-other-info'></i></label>
							<div class='input-group'>
									<input type='text' class='form-control' placeholder='Tiêu đề' name='infos[${infosLen}][label]'>
									<input type='text' class='form-control' placeholder='Nội dung' name='infos[${infosLen}][detail]'>
							</div>
					</div>`;

	$('#addInfoWrap').before(xml);
	$(`input[name='infos[${infosLen}][label]']`).rules('add', {
		required: true,
		maxlength: 500,
	});
	$(`input[name='infos[${infosLen}][detail]']`).rules('add', {
		required: true,
		maxlength: 500,
	});
	onRemoveOtherInfoInput();
	infosLen++;
}

function autoTrimInputOnChange() {
	$('input[type="text"]').on('change', function () {
		$(this).val($(this).val().trim());
	});
}

$.validator.addMethod(
	'expCheck',
	function (value, element) {
		const expDate = new Date(value).getTime();

		const mfg = $('#mfg').val();
		if (!mfg) return false;
		const mfgDate = new Date(mfg).getTime();

		if (expDate < mfgDate) return false;

		return true;
	},
	'Ngày hết hạn không hợp lệ',
);
$.validator.addMethod(
	'mfgCheck',
	function (value, element) {
		const mfgDate = new Date(value).getTime();
		if (mfgDate > Date.now()) return false;
		return true;
	},
	'Ngày sản xuất không hợp lệ',
);
$.validator.addMethod(
	'checkAvt',
	function (value, element) {
		const imgSize = $(element)[0].files[0].size;
		if (imgSize > IMG_MAX_SIZE) return false;
		return true;
	},
	'Hình ảnh kích thước tối đa 2MB',
);
$.validator.addMethod(
	'checkPhotos',
	function (value, element) {
		const images = $(element)[0].files;
		const len = images.length;
		if (len > MAX_PHOTOS_LEN) return false;

		for (let i = 0; i < len; ++i) {
			const size = images[i].size;
			if (size > IMG_MAX_SIZE) return false;
		}
		return true;
	},
	`Tối đa ${MAX_PHOTOS_LEN} ảnh. Mỗi hình ảnh kích thước tối đa 2MB`,
);

jQuery(function () {
	loadNicEditor();
	autoTrimInputOnChange();

	$('#addProductForm').validate({
		validClass: 'field-valid',
		errorClass: 'field-error',
		errorElement: 'p',
		ignore: '.nicEdit-main, .validate-ignore',

		rules: {
			name: {
				required: true,
				minlength: 8,
				maxlength: 150,
				nowhitespace: true,
			},
			catalog: {
				required: true,
			},
			price: {
				required: true,
				number: true,
				min: 500,
				max: 1_000_000_00,
			},
			stock: {
				required: true,
				number: true,
				min: 0,
				max: 100_000,
			},
			discount: {
				number: true,
				min: 0,
				max: 100,
			},
			unit: {
				required: true,
				minlength: 1,
				maxlength: 100,
			},
			mfg: {
				required: true,
				dateISO: true,
				mfgCheck: true,
			},
			exp: {
				required: true,
				dateISO: true,
				expCheck: true,
			},
			avt: {
				required: true,
				checkAvt: true,
			},
			origin: {
				required: true,
				minlength: 2,
				maxlength: 100,
			},
			brand: {
				required: true,
				minlength: 2,
				maxlength: 255,
			},
			'photos[]': {
				required: true,
				checkPhotos: true,
			},
		},

		messages: {
			name: {
				required: 'Vui lòng nhập tên sản phẩm',
				minlength: 'Tên sản phẩm ít nhất 8 ký tự',
				maxlength: 'Tên sản phẩm nhiều nhất 150 ký tự',
			},
			catalog: {
				required: 'Vui lòng chọn danh mục sản phẩm',
			},
			price: {
				required: 'Vui lòng nhập giá sản phẩm',
				number: 'Giá phải là một số',
				min: 'Giá tối thiểu 1.000 đ',
				max: 'Giá tối đa 1.000.000.000 đ',
			},
			stock: {
				required: 'Vui lòng nhập SL tồn kho',
				min: 'Tối thiểu là 0',
				max: 'Tối đa là 100.000',
			},
			discount: {
				min: 'Tối thiểu là 0%',
				max: 'Tối đa là 100%',
			},
			unit: {
				required: 'Vui lòng nhập đơn vị',
				minlength: 'Tối thiểu 1 ký tự',
				maxlength: 'Tối đa 100 ký tự',
			},
			mfg: {
				required: 'Vui lòng nhập ngày sản xuất',
			},
			exp: {
				required: 'Vui lòng nhập ngày hết hạn',
			},
			avt: {
				required: 'Vui lòng chọn ảnh đại diện',
			},
			origin: {
				required: 'Vui lòng nhập xuất xứ',
				minlength: 'Tối thiểu 2 ký tự',
				maxlength: 'Tối đa 100 ký tự',
			},
			brand: {
				required: 'Vui lòng nhập thương hiệu',
				minlength: 'Tối thiểu 2 ký tự',
				maxlength: 'Tối đa 100 ký tự',
			},
			'photos[]': {
				required: 'Tối thiểu 1 hình ảnh',
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
			const desc = nicEditors.findEditor('desc').getContent();

			if (!desc || !desc.trim() || desc === '<br>') {
				const ok = confirm(
					'Chưa nhập "Mô tả sản phẩm", bạn có chắc muốn thêm ?',
				);
				if (!ok) {
					return;
				}
			}

			$(form).append(`<input name="desc" type="hidden" value="${desc}" />`);
			form.submit();
		},
	});

	$('#addInfoInputBtn').on('click', renderOtherInfoInput);

	$('#resetBtn').on('click', function () {
		$('#addProductForm input[type="number"]').val(0);
		$('#addProductForm input[type!="number"], #addProductForm select').val(
			null,
		);
		nicEditors.findEditor('desc').setContent('');
	});
});
