var previewImage = function (input, block) {
	var fileTypes = ['jpg', 'jpeg', 'png'];
	var extension = input.files[0].name.split('.').pop().toLowerCase();
	var isSuccess = fileTypes.indexOf(extension) > -1;

	if (isSuccess) {
		var reader = new FileReader();

		reader.onload = function (e) {
			block.attr('src', e.target.result);
		};
		reader.readAsDataURL(input.files[0]);
	}
};

jQuery(function () {
	$('#avt').on('change', function () {
		previewImage(this, $('#avtImg'));
	});
});
