let currentOrderId = null;
let currentShipperId = null;

jQuery(function () {
  $(".confirm-btn").on("click", async function () {
    const orderId = $(this).attr("data-orderId");
    const shipperId = $(this).attr("data-shipperId");

    currentOrderId = orderId;
    currentShipperId = Number(shipperId);

    if (!currentShipperId || !ORDER_SERVICE_API_URL) return;

    const response = await fetch(
      `${ORDER_SERVICE_API_URL}/confirm-order?orderId=${currentOrderId}&shipperId=${currentShipperId}`,
      { method: "PUT" }
    );

    if (response.status === 200) {
      alert("Tiếp nhận đơn hàng thành công!");
      window.location.href = "/";
    }
  });
});
