function currencyFormat(price = 0) {
	return new Intl.NumberFormat('vi-VN', {
		style: 'currency',
		currency: 'VND',
	}).format(price);
}

function toThumbnail(src = '') {
	const strArr = src.split('.');
	if (strArr.length > 1) {
		const fileExt = strArr[strArr.length - 1];
		const thumbSrc = src.replace(`.${fileExt}`, `_thumb.${fileExt}`);
		return thumbSrc;
	}
	return src;
}
