const IMG_MAX_SIZE = 2 * 1024 * 1024; // 2 MB
const MAX_PHOTOS_LEN = 10;
let infosLen = 0;

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

$.validator.addMethod(
  "expCheck",
  function (value, element) {
    const expDate = new Date(value).getTime();

    const mfg = $("#mfg").val();
    if (!mfg) return false;
    const mfgDate = new Date(mfg).getTime();

    if (expDate < mfgDate) return false;

    return true;
  },
  "Ngày hết hạn không hợp lệ"
);
$.validator.addMethod(
  "mfgCheck",
  function (value, element) {
    const mfgDate = new Date(value).getTime();
    if (mfgDate > Date.now()) return false;
    return true;
  },
  "Ngày sản xuất không hợp lệ"
);
$.validator.addMethod(
  "checkAvt",
  function (value, element) {
    const imgSize = $(element)[0].files[0].size;
    if (imgSize > IMG_MAX_SIZE) return false;
    return true;
  },
  "Hình ảnh kích thước tối đa 2MB"
);
$.validator.addMethod(
  "checkPhotos",
  function (value, element) {
    const images = $(element)[0].files;
    const len = images.length;
    if (len > MAX_PHOTOS_LEN) return false;

    for (let i = 0; i < len; ++i) {
      const size = images[i].size;
      if (size > IMG_MAX_SIZE) return false;
    }
    return true;
  },
  `Tối đa ${MAX_PHOTOS_LEN} ảnh. Mỗi hình ảnh kích thước tối đa 2MB`
);

jQuery(function () {
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

  $(".update-product").on("click", function () {
    if (!myEditor) {
      loadNicEditor($(this).attr("desc-id"));
    } else {
      removeNicEditor($(this).attr("desc-id"));
      loadNicEditor($(this).attr("desc-id"));
    }
  });

  $("#updateProductForm").validate({
    validClass: "field-valid",
    errorClass: "field-error",
    errorElement: "p",
    ignore: ".nicEdit-main, .validate-ignore",

    rules: {
      name: {
        required: true,
        minlength: 8,
        maxlength: 150,
      },
      catalog: {
        required: true,
      },
      price: {
        required: true,
        number: true,
        min: 500,
        max: 1_000_000_00,
      },
      stock: {
        required: true,
        number: true,
        min: 0,
        max: 100_000,
      },
      discount: {
        number: true,
        min: 0,
        max: 100,
      },
      unit: {
        required: true,
        minlength: 1,
        maxlength: 100,
      },
      mfg: {
        required: true,
        dateISO: true,
        mfgCheck: true,
      },
      exp: {
        required: true,
        dateISO: true,
        expCheck: true,
      },
      origin: {
        required: true,
        minlength: 2,
        maxlength: 100,
      },
      brand: {
        required: true,
        minlength: 2,
        maxlength: 255,
      },
    },

    messages: {
      name: {
        required: "Vui lòng nhập tên sản phẩm",
        minlength: "Tên sản phẩm ít nhất 8 ký tự",
        maxlength: "Tên sản phẩm nhiều nhất 150 ký tự",
      },
      catalog: {
        required: "Vui lòng chọn danh mục sản phẩm",
      },
      price: {
        required: "Vui lòng nhập giá sản phẩm",
        number: "Giá phải là một số",
        min: "Giá tối thiểu 1.000 đ",
        max: "Giá tối đa 1.000.000.000 đ",
      },
      stock: {
        required: "Vui lòng nhập SL tồn kho",
        min: "Tối thiểu là 0",
        max: "Tối đa là 100.000",
      },
      discount: {
        min: "Tối thiểu là 0%",
        max: "Tối đa là 100%",
      },
      unit: {
        required: "Vui lòng nhập đơn vị",
        minlength: "Tối thiểu 1 ký tự",
        maxlength: "Tối đa 100 ký tự",
      },
      mfg: {
        required: "Vui lòng nhập ngày sản xuất",
      },
      exp: {
        required: "Vui lòng nhập ngày hết hạn",
      },
      origin: {
        required: "Vui lòng nhập xuất xứ",
        minlength: "Tối thiểu 2 ký tự",
        maxlength: "Tối đa 100 ký tự",
      },
      brand: {
        required: "Vui lòng nhập thương hiệu",
        minlength: "Tối thiểu 2 ký tự",
        maxlength: "Tối đa 100 ký tự",
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
