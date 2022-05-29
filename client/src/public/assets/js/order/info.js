async function getCartData(cart = []) {
	const products = [];
	const promise = [];

	cart.forEach((cartItem) => {
		if (cartItem.hasOwnProperty('productId')) {
			promise.push(
				fetch(`${PRODUCT_SERVICE_API_URL}/id/${cartItem.productId}`)
					.then((data) => data.json())
					.then((product) => {
						products.push({
							...product,
							quantity:
								cartItem.quantity <= product.stock
									? cartItem.quantity <= 0
										? 1
										: cartItem.quantity
									: product.stock,
						});
					}),
			);
		}
	});

	await Promise.all(promise);
	return products;
}

function showError(msg) {
	$('#error').removeClass('d-none').html(msg);
}

jQuery(async function () {
	const cart = getCart();

	if (!cart || !cart.length) {
		window.location.href = '/';
		return;
	}

	// reload cart
	const products = await getCartData(cart);
	products.sort((p1, p2) => p1.price - p2.price);
	removeAllCart();
	products.forEach((p) => {
		addToCart({
			productId: p._id,
			quantity: p.quantity,
			price: p.price,
			discount: p.discount,
		});
	});
	loadCartSummary();

	const cartTotal = products.reduce(
		(sum, p) => sum + p.quantity * ((p.price * (100 - p.discount)) / 100),
		0,
	);
	$('#cartTotal').html(currencyFormat(cartTotal));
	$('#shippingFee').html(currencyFormat(SHIPPING_FEE));
	$('#orderTotal').html(
		currencyFormat(Number(cartTotal) + Number(SHIPPING_FEE)),
	);

	$('#momoQRBtn').on('click', function () {
		$('#form').attr('action', '/thanh-toan-momo-qr-code').submit();
	});

	$('#momoATMBtn').on('click', function () {
		$('#form').attr('action', '/thanh-toan-momo-atm').submit();
	});

	$('#form').on('submit', function (e) {
		e.preventDefault();
		const receiverName = $('#receiverName').val().trim();
		const receiverPhone = $('#receiverPhone').val().trim();
		const addrDetail = $('#addrDetail').val().trim();
		const note = $('#note').val().trim();
		const provinceId = Number($('#province').val());
		const districtId = Number($('#district').val());
		const wardId = Number($('#ward').val());

		if (!receiverName) return showError('Vui lòng nhập tên người nhận');
		if (!receiverPhone) return showError('Vui lòng số điện thoại người nhận');
		if (receiverName.length > 150) return showError('Tên tối đa 150 ký tự');
		if (!/^0[1-9]\d{8}$/.test(receiverPhone))
			return showError('Số điện thoại người nhận không hợp lệ');

		if (!addrDetail || provinceId <= 0 || districtId <= 0 || wardId <= 0)
			return showError('Vui lòng nhập địa chỉ');

		if (note.length > 500) return showError('Ghi chú tối đa 500 ký tự');

		$('#error').addClass('d-none');
		$('#form button').addClass('disabled');
		$(this).append(
			`<input type='number' name='cartTotal' value='${cartTotal}' class='d-none' />`,
			`<input type='text' name='cart' 
							value='${JSON.stringify(getCart())}' class='d-none' />`,
		);

		this.submit();
	});
});
