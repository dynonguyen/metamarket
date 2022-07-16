let currentOrderId = null;
let currentOrderStatus = null;
let currentOrderCode = null;

jQuery(function () {
  $(".update-btn").on("click", async function () {
    const orderId = $(this).attr("data-orderId");
    const orderStatus = $(this).attr("data-orderStatus");
    const orderCode = $(this).attr("data-orderCode");

    currentOrderId = orderId;
    currentOrderStatus = Number(orderStatus);
    currentOrderCode = orderCode;

    let status = null;
    if (currentOrderStatus >= 5) {
      status = 1;
    } else {
      status = ++currentOrderStatus;
    }

    if (!currentOrderId || !ORDER_SERVICE_API_URL) return;

    const response = await fetch(
      `${ORDER_SERVICE_API_URL}/update-status?orderId=${currentOrderId}&status=${status}`,
      { method: "PUT" }
    );

    if (response.status === 200) {
      alert(`Cập nhật trạng thái đơn ${currentOrderCode} thành công!`);
      window.location.reload();
    }
  });
});
