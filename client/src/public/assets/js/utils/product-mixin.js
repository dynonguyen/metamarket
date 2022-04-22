function renderProductCard({ _id, name, avt, price, unit, discount }) {
	return `<div class="col">
          <div class="product-card">
            <a href="/san-pham/${_id}" class="product-top">
                <img class="product-avt" src="${avt}" alt="${name}" title="${name}">
            </a>
            <div class="product-content">
                <a class="product-name" href="/san-pham/${_id}" title="${name}">
                    <h3 class="product-name">${name}</h3>
                </a>
                <div class="product-unit">ĐVT: ${unit}</div>
                <div class="product-price">
                    <div class="vertical-center">
                        <strong>${currencyFormat(price)}</strong>
                        ${
													discount
														? `<label class="discount-rate">-${discount}%</label>`
														: ''
												}
                    </div>
                    ${
											discount
												? `<div class="discount">
												${currencyFormat((price * discount) / 100)}
												</div>`
												: ''
										}
                </div>
            </div>
            <div class="product-bottom">
                <button class="btn btn-outline-primary-accent">Thêm giỏ hàng</button>
            </div>
        </div>
      </div>`;
}

function renderProductList(products = []) {
	let xml = '';

	products.forEach((product) => {
		xml += renderProductCard({ ...product });
	});

	return xml;
}
