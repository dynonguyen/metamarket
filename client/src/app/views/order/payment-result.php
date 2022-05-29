<style>
    #footer {
        position: fixed;
        bottom: 0;
    }
</style>

<div class='py-4 payment-result'>
    <div class='container bg-white p-5 flex-center flex-column'>
        <?php if (isset($isError) && $isError == 0) { ?>
            <i class='bi bi-check-circle-fill' style="font-size: 5rem; color: var(--bs-success)"></i>
            <p class="fs-2 text-gray text-center mt-4">Đơn hàng của bạn đã thanh toán thành công.</p>
            <p class="fs-2 text-gray text-center mb-4">Chúng tôi sẽ vận chuyển đơn hàng đến bạn một cách sớm nhất. Xin cảm ơn !</p>
            <a href='/'>
                <button class="btn btn-primary fs-3 px-5 py-2">Tiếp tục mua sắm</button>
            </a>
        <?php } else { ?>
            <i class='bi bi-x-circle-fill' style="font-size: 5rem; color: var(--bs-danger)"></i>
            <p class="fs-2 text-gray text-center mt-4">Đơn hàng của bạn thanh toán không thành công.</p>
            <p class="fs-2 text-gray text-center mb-4">
                <?php echo !empty($errorMessage) ? $errorMessage : "Có thể do sự cố về đường truyền hoặc xảy ra lỗi thanh toán. Vui lòng thử lại !"; ?>
            </p>
            <a href='/thong-tin-giao-hang'>
                <button class="btn btn-primary fs-3 px-5 py-2">Thử lại</button>
            </a>

        <?php } ?>
    </div>
</div>