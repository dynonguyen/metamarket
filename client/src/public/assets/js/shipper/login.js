const MAX_LEN_USERNAME = 20;
const MAX_LEN_PASSWORD = 100;

function showFormError(msg = "") {
  $("#formError").html(msg).removeClass("d-none");
}

jQuery(function () {
  $("#form").on("submit", function (e) {
    e.preventDefault();

    const username = $("#username").val()?.trim();
    const password = $("#password").val()?.trim();

    if (username.length > MAX_LEN_USERNAME) {
      return showFormError(`Username tối đa ${MAX_LEN_USERNAME} ký tự !`);
    }

    if (!password) {
      return showFormError("Vui lòng nhập mật khẩu !");
    }

    if (password.length > MAX_LEN_PASSWORD) {
      return showFormError(`Mật khẩu tối đa ${MAX_LEN_PASSWORD} ký tự !`);
    }

    this.submit();
  });

  $(".password-icon").on("click", function () {
    if ($(this).hasClass("bi-eye-slash-fill")) {
      $(this).removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
      $(this).siblings("input").attr("type", "text");
    } else {
      $(this).removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
      $(this).siblings("input").attr("type", "password");
    }
  });
});
