const staticUrl =
  typeof STATIC_FILE_URL !== "undefined" ? STATIC_FILE_URL : "/public";

let myEditor;

function loadNicEditor(descId) {
  myEditor = new nicEditor({
    iconsPath: `${staticUrl}/vendors/nicEdit/nicEditorIcons.gif`,
  }).panelInstance(descId);
  $(".nicEdit-main").parent("div").css({ width: "100%", padding: "8px" });
  $(".nicEdit-panelContain").parent("div").css({ width: "100%" });
}

function removeNicEditor(descId) {
  myEditor.removeInstance(descId);
  myEditor = null;
}

jQuery(function () {
  $(".update-product").on("click", function () {
    if (!myEditor) {
      loadNicEditor($(this).attr("desc-id"));
    } else {
      removeNicEditor($(this).attr("desc-id"));
      loadNicEditor($(this).attr("desc-id"));
    }

    console.log("update product click");
    console.log($(this).attr("desc-id"));
  });

  const url = new URL(location.href);

  $("#sort").val(sort);
  $("#filter").val(filter);

  $("#sort").on("change", function () {
    const value = $(this).val();
    if (!value) url.searchParams.delete("s");
    else url.searchParams.set("s", value);
    location.href = url.href;
  });

  $("#filter").on("change", function () {
    const value = $(this).val();
    if (!value) {
      url.searchParams.delete("q");
      url.searchParams.delete("f");
    } else {
      let query = {};
      switch (value) {
        case "exp":
          query = { exp: { $lt: new Date() } };
          break;
        case "discount":
          query = { discount: { $gt: 0 } };
          break;
        case "no-discount":
          query = { discount: 0 };
          break;
        case "no-stock":
          query = { stock: 0 };
          break;
      }
      url.searchParams.set("q", JSON.stringify(query));
      url.searchParams.set("f", value);
    }

    location.href = url.href;
  });
});
