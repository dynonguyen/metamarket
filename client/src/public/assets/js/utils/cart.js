const LS_CART_KEY = 'mm-cart';

function currencyFormat(price = 0) {
	return new Intl.NumberFormat('vi-VN', {
		style: 'currency',
		currency: 'VND',
	}).format(price);
}

function getCart() {
	const cartStr = localStorage.getItem(LS_CART_KEY);
	if (!cartStr) {
		return [];
	}
	const cart = JSON.parse(cartStr);
	return Array.isArray(cart) ? cart : [];
}

function addToCart({ productId, quantity, price = 0, discount = 0 }) {
	const cart = getCart();

	const productIndex = cart.findIndex((p) => p.productId === productId);
	if (productIndex === -1) {
		cart.push({ productId, quantity, price, discount });
	} else {
		cart[productIndex].quantity += quantity;
	}

	localStorage.setItem(LS_CART_KEY, JSON.stringify(cart));
}

function loadCartSummary() {
	const cart = getCart();
	if (cart && cart.length > 0) {
		const cartTotal = cart.reduce((sum, p) => sum + p.quantity, 0);
		const cartTotalMoney = cart.reduce(
			(sum, p) => sum + p.quantity * p.price,
			0,
		);
		$('span[id^="cartQuantity"]').text(`(${cartTotal})`);
		$('#cartMoney').text(currencyFormat(cartTotalMoney));
	} else {
		$('span[id^="cartQuantity"]').text('');
		$('#cartMoney').text('');
	}
}

function removeAllCart() {
	localStorage.setItem(LS_CART_KEY, []);
}

function removeCartItem(id) {
	const cart = getCart();
	const newCart = cart.filter((p) => p.productId !== id);
	localStorage.setItem(LS_CART_KEY, JSON.stringify(newCart));
}

function updateQuantityCart(productId, quantity) {
	const cart = getCart();
	const newCart = cart.map((p) =>
		p.productId === productId ? { ...p, quantity } : p,
	);
	localStorage.setItem(LS_CART_KEY, JSON.stringify(newCart));
}

jQuery(function () {
	loadCartSummary();

	$('.add-cart').on('click', function () {
		const productId = $(this).attr('data-id');
		const productPrice = $(this).attr('data-price');
		const productStock = Number($(this).attr('data-stock'));
		const productDiscount = Number($(this).attr('data-discount'));

		if (productId) {
			addToCart({
				productId,
				quantity: 1,
				price: Number(productPrice),
				discount: productDiscount,
			});
			$(this).attr('data-stock', productStock - 1);
			if (productStock - 1 <= 0) {
				$(this)
					.parent('.product-bottom')
					.html(
						'<button class="btn btn-accent disabled">Tạm hết hàng</button>',
					);
			}
			loadCartSummary();
			if (showToast) {
				showToast();
			}
		}
	});
});
