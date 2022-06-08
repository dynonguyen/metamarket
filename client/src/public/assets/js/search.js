jQuery(function () {
  $("#search").on("click", function () {
    const keyword = $("#keywordInput").val().trim();
    if (keyword) {
      window.location.href = `/tim-kiem?keyword=${keyword}`;
    }
  });
  $("#searchshipper").on("click", function () {
    const keyword = $("#keywordInput").val().trim();
    if (keyword) {
      window.location.href = `?keyword=${keyword}`;
    }
  });
});
