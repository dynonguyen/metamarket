let cartTotal = 0;
let products = [];
const staticUrl =
	typeof STATIC_FILE_URL !== 'undefined' ? STATIC_FILE_URL : '/public';

function renderEmptyCart() {
	const xml = `<div class="flex-column flex-center p-5">
    <img src="${staticUrl}/assets/images/empty.png" style="width: 150px" />
    <h4 class="my-5">Giỏ hàng chưa có sản phẩm</h4>
    <button class="btn btn-primary">
      <a href="/" class="text-light">Tiếp tục mua sắm</a>
    </button>
  </div>`;

	$('#cartWrapper').html(xml);
}

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

function renderCartSummary() {
	const xml = `<div class='bg-white summary p-4'>
						<div class='d-flex justify-content-between'>
								<span>Tạm tính:</span>
								<b>${currencyFormat(cartTotal)}</b>
						</div>
						<div class='d-flex justify-content-between'>
								<span>Phí vận chuyển:</span>
								<b>Chưa tính</b>
						</div>
						<div class='d-flex justify-content-between'>
								<span>Thành tiền:</span>
								<b class="text-danger">${currencyFormat(cartTotal)}</b>
						</div>
						<div class='text-end text-gray'>
								<i>(Giá đã bao gồm VAT)</i>
						</div>
						<a href='/thong-tin-giao-hang'>
							<button class='btn btn-accent w-100 mt-5'>Đặt hàng</button>
						</a>
				</div>`;

	$('#cartSummary').html(xml);
}

function renderProductCart(product) {
	const {
		_id,
		avt,
		price,
		stock,
		unit,
		name,
		quantity,
		discount = 0,
	} = product;
	const thumbAvt = toThumbnail(`${staticUrl}/${avt}`);
	const priceDiscount = (price * (100 - discount)) / 100;

	const xml = `<div class='cart-item row g-2' data-id='${_id}'>
						<div class="col col-12 col-lg-7 vertical-center">
								<img src='${thumbAvt}' alt='${name}'>
								<div class='d-flex flex-column mx-4'>
										<a href='/san-pham/${_id}' class='name'>${name}</a>
										<span class="unit">ĐVT: ${unit} (có sẵn: ${stock})</span>
										<div class="vertical-center remove-item mt-1" data-id="${_id}">
												<i class='bi bi-trash-fill me-2'></i>
												<span>Xoá khỏi giỏ hàng</span>
										</div>
								</div>
						</div>
						<div class="col col-12 col-lg-5 vertical-center cart-action-wrap">
								<div class='price'>${currencyFormat(priceDiscount)}</div>
								
								<div class='input-group cart-action ms-5'>
										<button type='button' class='btn btn-outline-primary decrease' data-id='${_id}'>-</button>
										<input value='${quantity}' type='text' min='1' max='${stock}' class='form-control' data-id='${_id}'>
										<button type='button' class='btn btn-outline-primary increase' data-id='${_id}'>+</button>
								</div>
						</div>
				</div>`;

	$('#cart').append(xml);
}

function updateProductInCart(productId, quantity) {
	const index = products.findIndex((p) => p._id === productId);
	if (index !== -1) {
		products[index].quantity += quantity;

		const { price, discount = 0 } = products[index];
		cartTotal += ((price * (100 - discount)) / 100) * quantity;
		$(`.cart-action input[data-id="${productId}"]`).val(
			products[index].quantity,
		);
		updateQuantityCart(productId, products[index].quantity);
		loadCartSummary();
		renderCartSummary();
	}
}

jQuery(async function () {
	const cart = getCart();

	if (!cart || !cart.length) {
		renderEmptyCart();
		return;
	}

	products = await getCartData(cart);
	products.sort((p1, p2) => p1.price - p2.price);

	cartTotal = products.reduce(
		(sum, p) => sum + p.quantity * p.price * ((100 - p.discount) / 100),
		0,
	);

	renderCartSummary();

	// reload & render cart
	removeAllCart();
	products.forEach((p) => {
		addToCart({
			productId: p._id,
			quantity: p.quantity,
			price: p.price,
			discount: p.discount,
		});
		renderProductCart(p);
	});
	loadCartSummary();

	// remove all cart
	$('#removeAllBtn').click(function () {
		cartTotal = 0;
		products = [];
		removeAllCart();
		loadCartSummary();
		renderEmptyCart();
		loadCartSummary();
	});

	$('.remove-item').on('click', function () {
		const productId = $(this).attr('data-id');
		const product = products.find((p) => p._id === productId);

		if (product) {
			const { price, quantity } = product;
			cartTotal -= price * quantity;

			$(`.cart-item[data-id="${productId}"]`).remove();
			products = products.filter((p) => p._id !== productId);
			if (products.length === 0) {
				renderEmptyCart();
			}
			removeCartItem(productId);
			renderCartSummary();
			loadCartSummary();
		}
	});

	$('.cart-action .increase').on('click', function () {
		const productId = $(this).attr('data-id');
		const { quantity, stock } = products.find((p) => p._id === productId);
		if (quantity < stock) {
			updateProductInCart(productId, 1);
		}
	});

	$('.cart-action .decrease').on('click', function () {
		const productId = $(this).attr('data-id');
		const { quantity } = products.find((p) => p._id === productId);
		if (quantity > 1) {
			updateProductInCart(productId, -1);
		}
	});

	$('.cart-action input').on('change', function () {
		const productId = $(this).attr('data-id');
		const { stock, quantity } = products.find((p) => p._id === productId);
		let newQuantity = Number($(this).val());

		if (isNaN(newQuantity) || newQuantity < 1 || newQuantity > stock) {
			$(this).val(quantity);
			return;
		}

		updateProductInCart(productId, newQuantity - quantity);
	});
});
