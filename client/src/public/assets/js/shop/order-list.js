let updateOrderId = null;

function renderOrderDetailItem(label, content) {
	return `<div class="d-flex fs-3 mb-3">
          <span>${label}:</span>
          <span class="ms-3 text-gray">${content}</span>
      </div>`;
}

function renderOrderDetail(order) {
	const {
		orderCode,
		orderDate,
		receiverName,
		receiverPhone,
		orderStatus,
		orderTotal,
		transportFee,
		note,
		user,
		products,
	} = order;
	$('#orderDetailModal .modal-body').html('');

	let xml = '';

	xml += renderOrderDetailItem('Tên khách hàng', user.fullname);
	xml += renderOrderDetailItem('Mã đơn hàng', orderCode);
	xml += renderOrderDetailItem('Ngày đặt hàng', dateFormat(orderDate));
	xml += renderOrderDetailItem('Người nhận hàng', receiverName);
	xml += renderOrderDetailItem('SĐT người nhận', receiverPhone);
	xml += renderOrderDetailItem('Trạng thái đơn hàng', orderStatus);
	xml += renderOrderDetailItem('Tổng giá đơn hàng', currencyFormat(orderTotal));
	xml += renderOrderDetailItem('Phí vận chuyển', currencyFormat(transportFee));
	xml += renderOrderDetailItem('Ghi chú', note);

	xml += '<div class="fs-3">Danh sách sản phẩm</div>';
	products.forEach((product) => {
		xml += `<div class='d-flex mb-3 fs-3 text-gray'>
              <u>${product.name}</u> - giá ${currencyFormat(
			product.price,
		)} - giảm giá ${product.discount}% - số lượng ${product.quantity}
            </div>`;
	});

	$('#orderDetailModal .modal-body').append(xml);
}

jQuery(function () {
	$('.show-detail-icon').on('click', async function () {
		const orderId = $(this).attr('data-id');
		const orderCode = $(this).attr('data-code');
		const apiRes = await fetch(
			`${ORDER_SERVICE_API_URL}/detail-by-id/${orderId}`,
		);
		if (apiRes.status === 200) {
			const order = await apiRes.json();
			renderOrderDetail(order);
		}

		$('#orderCodeModal').html(`<b>#${orderCode}</b>`);
	});

	$('.update-order-icon').on('click', function () {
		const orderId = $(this).attr('data-id');
		const orderStatus = Number($(this).attr('data-order-status'));
		if (orderStatus > Number(SHIPPING_STATUS)) {
			$('#orderStatusModal p.error').removeClass('d-none');
			$('#orderStatusSelect').addClass('disabled');
			$('#updateOrderBtn').addClass('disabled');
			return;
		}

		$('#orderStatusModal p.error').addClass('d-none');
		$('#orderStatusSelect').removeClass('disabled');
		$('#updateOrderBtn').removeClass('disabled');
		$('#orderStatusSelect').val(orderStatus);
		updateOrderId = orderId;
	});

	$('#updateOrderBtn').on('click', async function () {
		const newStatus = Number($('#orderStatusSelect').val());
		const apiRes = await fetch(
			`${ORDER_SERVICE_API_URL}/update-status?orderId=${updateOrderId}&status=${newStatus}`,
			{ method: 'PUT' },
		);
		if (apiRes.status === 200) {
			const statusStr =
				newStatus === Number(SHIPPING_STATUS)
					? 'Đang giao hàng'
					: 'Chờ cửa hàng xử lý';
			$(`tr[data-order-id='${updateOrderId}'] td:nth-child(3)`).text(statusStr);
			$(`.update-order-icon[data-id='${updateOrderId}']`).attr(
				'data-order-status',
				newStatus,
			);
			$('#orderStatusModal .btn-close').click();
		}
	});
});
