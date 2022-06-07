const staticUrl =
  typeof STATIC_FILE_URL !== "undefined" ? STATIC_FILE_URL : "/public";

function autoTrimInputOnChange() {
  $('input[type="text"]').on("change", function () {
    $(this).val($(this).val().trim());
  });
}
jQuery(function () {
  autoTrimInputOnChange();
  $("#addShipper").validate({
    validClass: "field-valid",
    errorClass: "field-error",
    errorElement: "p",
    ignore: ".nicEdit-main, .validate-ignore",

    rules: {
      shipperid: {
        required: true,
      },
      username: {
        required: true,
        minlength: 6,
        maxlength: 150,
      },
      address: {
        required: true,
        minlength: 8,
        maxlength: 150,
      },
      driverlicense: {
        required: true,
        minlength: 6,
        maxlength: 150,
      },
      peopleid: {
        required: true,
        minlength: 9,
        maxlength: 12,
      },
      password: {
        required: true,
        minlength: 3,
        maxlength: 20,
      },
    },

    messages: {
      shipperid: {
        required: "Vui lòng nhập mã shipper",
      },
      username: {
        required: "Vui lòng nhập tên tài khoản",
        minlength: "Tên tài khoản ít nhất 6 ký tự",
        maxlength: "Tên tài khoản nhiều nhất 150 ký tự",
      },
      address: {
        required: "Vui lòng nhập địa chỉ",
        minlength: "Địa chỉ ít nhất 8 ký tự",
        maxlength: "Địa nhiều nhất 150 ký tự",
      },
      driverlicense: {
        required: "Vui lòng nhập GPLX",
        minlength: "GPLX ít nhất 8 ký tự",
        maxlength: "GPLX nhiềunhất 150 ký tự",
      },
      peopleid: {
        required: "Vui lòng nhập CMND/CCCD",
        minlength: "CMND/CCCD ít nhất 9 ký tự",
        maxlength: "CMND/CCCD nhiều nhất 12 ký tự",
      },
      password: {
        required: "Vui lòng nhập password",
        minlength: "password ít nhất 3 ký tự",
        maxlength: "password nhiều nhất 20 ký tự",
      },
    },

    invalidHandler: function (e, validator) {
      const { errorList } = validator;
      if (errorList) {
        errorList.forEach((item) => {
          $(item.element).addClass("field-error");
        });
      }
    },

    submitHandler: function (form, e) {
      e.preventDefault();
      form.submit();
    },
  });
});
