let currentAccountId = null,
	currentStatus = null;

jQuery(function () {
	$('.shop-more').on('click', function () {
		const shopId = $(this).attr('data-id');
		const tr = $(`tr[data-id="${shopId}"]`);

		const businessLicense = tr.attr('data-bl');
		const foodSafetyCertificate = tr.attr('data-fsc');
		const status = tr.attr('data-status');
		const accountId = tr.attr('data-accountId');

		// save shop info for updating
		currentAccountId = Number(accountId);
		currentStatus = Number(status);

		$('#businessLicense').attr('src', businessLicense);
		$('#foodSafetyCertificate').attr('src', foodSafetyCertificate);
		$('#status').val(status);
	});

	$('#updateBtn').on('click', async function () {
		if (!currentAccountId || !USER_SERVICE_API_URL) return;

		const status = Number($('#status').val());
		if (status === currentStatus) return;

		const response = await fetch(
			`${USER_SERVICE_API_URL}/account/update-status?accountId=${currentAccountId}&status=${status}`,
			{ method: 'PUT' },
		);

		if (response.status === 200) {
			alert('Cập nhật thành công !');
			window.location.reload();
		}
	});
});
