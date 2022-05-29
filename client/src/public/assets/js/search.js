jQuery(function () {
  $("#search").on("click", function () {
    const keyword = $("#keywordInput").val().trim();
    if (keyword) {
      window.location.href = `/tim-kiem?keyword=${keyword}`;
    }
  });
});
jQuery(function () {
  $("#searchshipper").on("click", function () {
    const keyword = $("#keyworshipper").val().trim();
    if (keyword) {
      window.location.href = `/tim-kiem-shipper?keyword=${keyword}`;
    }
  });
});
