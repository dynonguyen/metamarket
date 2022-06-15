function showFormError(msg = "") {
  $("#formError").html(msg).removeClass("d-none");
}

jQuery(function () {
  $("#form").on("submit", function (e) {
    e.preventDefault();

    const name = $("#name").val()?.trim();
    const phone = $("#phone").val()?.trim();
    const gender = $("#gender");
    const dbo = $("#dbo");

    if (!name || !phone || !gender || !phone) {
      return showFormError("Vui lòng nhập đủ các trường !");
    }

    this.submit();
  });
});
