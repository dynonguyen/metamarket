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

jQuery(function () {
	// Load more
	$('.catalog-more').on('click', async function () {
		$(this).addClass('disabled');
		$(this).find('.spinner-border').removeClass('d-none');

		const catalogId = $(this).attr('data-id');
		const page = Number($(this).attr('data-page'));
		const nextPage = page + 1;
		const pageSize = Number($(this).attr('data-size'));
		const select = '_id name price unit avt discount catalogId';

		try {
			const apiResStr = await fetch(
				`${PRODUCT_SERVICE_API_URL}/list/catalog/${catalogId}?page=${nextPage}&pageSize=${pageSize}&select=${select}`,
			);
			if (apiResStr.status === 200) {
				const productDocs = await apiResStr.json();
				const { docs, total } = productDocs;
				const productXml = renderProductList(docs);

				$(this).siblings('.product-list').append(productXml);
				$(this)
					.find('.rest')
					.html(total - (page * pageSize + docs.length));

				if (nextPage * pageSize >= total) {
					$(this).remove();
				} else {
					$(this).attr('data-page', nextPage);
				}
			}
		} catch (error) {
		} finally {
			if ($(this)) {
				$(this).removeClass('disabled');
				$(this).find('.spinner-border').addClass('d-none');
			}
		}
	});
});
