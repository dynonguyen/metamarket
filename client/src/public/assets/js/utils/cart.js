const LS_CART_KEY = 'mm-cart';

function getCart() {
	const cartStr = localStorage.getItem(LS_CART_KEY);
	if (!cartStr) {
		return [];
	}
	const cart = JSON.parse(cartStr);
	return Array.isArray(cart) ? cart : [];
}

function addToCart({ productId, quantity, price = 0 }) {
	const cart = getCart();

	const productIndex = cart.findIndex((p) => p.productId === productId);
	if (productIndex === -1) {
		cart.push({ productId, quantity, price });
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
	}
}

jQuery(function () {
	loadCartSummary();
	$('.add-cart').on('click', function () {
		const productId = $(this).attr('data-id');
		const productPrice = $(this).attr('data-price');
		if (productId) {
			addToCart({ productId, quantity: 1, price: Number(productPrice) });
			loadCartSummary();
		}
	});
});
