function showToast(timeout = 4000) {
	const toast = $('#toast');
	if (toast) {
		toast.addClass('show');
		setTimeout(() => {
			toast.removeClass('show');
		}, timeout);
	}
}

function hideToast() {
	const toast = $('#toast');
	if (toast) {
		toast.removeClass('show');
	}
}
