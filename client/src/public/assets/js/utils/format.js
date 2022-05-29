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

function dateFormat(time) {
	const date = new Date(time);
	const h = `0${date.getHours()}`.slice(-2);
	const m = `0${date.getMinutes()}`.slice(-2);
	const d = `0${date.getDate()}`.slice(-2);
	const month = `0${date.getMonth() + 1}`.slice(-2);
	const y = date.getFullYear();

	return `${h}:${m} ${d}-${month}-${y}`;
}
