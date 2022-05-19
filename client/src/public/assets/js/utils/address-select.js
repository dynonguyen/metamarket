function renderSelectOptions(
	select,
	options,
	labelKey,
	valueKey,
	defaultLabel,
	isProvince = false,
) {
	let xml = '';
	xml += `<option disabled selected value=''>${defaultLabel}</option>`;
	options.forEach((option) => {
		xml += `<option value=${option[valueKey]}>
    ${!isProvince ? `${option.prefix} ` : ''}${option[labelKey]}</option>`;
	});
	select.html(xml);
}

jQuery(async function () {
	const provinceSelect = $('select#province');
	const districtSelect = $('select#district');
	const wardSelect = $('select#ward');

	// get provinces
	fetch(`${USER_SERVICE_API_URL}/address/province/all`)
		.then((data) => data.json())
		.then((provinces) => {
			renderSelectOptions(
				provinceSelect,
				provinces,
				'name',
				'provinceId',
				'Chọn Tỉnh / Thành',
				true,
			);
		});

	$('#province').on('change', function (e) {
		const provinceId = Number(e.target.value);
		districtSelect.val('');
		wardSelect.val('');

		fetch(`${USER_SERVICE_API_URL}/address/district/by-province/${provinceId}`)
			.then((data) => data.json())
			.then((district) => {
				renderSelectOptions(
					districtSelect,
					district,
					'name',
					'districtId',
					'Chọn Quận / Huyện',
				);
				districtSelect.removeClass('disabled');
			});
	});

	$('#district').on('change', function (e) {
		const districtId = Number(e.target.value);
		wardSelect.val('');

		fetch(`${USER_SERVICE_API_URL}/address/ward/by-district/${districtId}`)
			.then((data) => data.json())
			.then((ward) => {
				renderSelectOptions(
					wardSelect,
					ward,
					'name',
					'wardId',
					'Chọn Xã / Phường',
				);
				wardSelect.removeClass('disabled');
			});
	});
});
