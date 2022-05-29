<div class='py-4 info-wrap'>
    <div class='container p-4 bg-white'>
        <h1 class='text-center mb-4 fs-1'>THÔNG TIN GIAO HÀNG</h1>

        <!-- Form -->
        <form id='form' method='POST'>
            <h3 class=' mb-3'>Thông tin người nhận hàng</h3>
            <div class='alert alert-danger fs-4 d-none' id='error'></div>

            <div class='row gx-4 gy-3'>
                <div class='col col-12 col-md-6'>
                    <input type='text' name='receiverName' id='receiverName' class='form-control form-control-lg' placeholder='Họ tên người nhận'>
                </div>
                <div class='col col-12 col-md-6'>
                    <input type='text' name='receiverPhone' id='receiverPhone' class='form-control form-control-lg' placeholder='SĐT người nhận'>
                </div>
            </div>

            <h3 class='mt-5 mb-3'>Địa chỉ nhận hàng</h3>

            <?php require_once _DIR_ROOT . '/app/views/blocks/address-select.php'; ?>

            <h3 class='mt-5 mb-3'>Ghi chú (nếu có)</h3>
            <textarea class='form-control' name='note' id="note" placeholder='Nhập ghi chú cho chủ cửa hàng hoặc người giao hàng (nếu có)'></textarea>
        </form>

        <div class='break my-4'></div>

        <!-- Cart summary -->
        <div class='cart-summary'>
            <div class='text-end'>
                <span class='label'>Tiền hàng:</span> <span class='value'><b id='cartTotal'>Đang tính ...</b></span>
            </div>
            <div class='text-end'>
                <span class='label'>phí giao hàng:</span> <span class='value'><b id='shippingFee'>Đang tính ...</b></span>
            </div>
            <div class='text-end'>
                <span class='label'>Tổng đơn hàng:</span> <span class='value text-danger'><b id='orderTotal'>Đang tính ...</b></span>
            </div>
        </div>

        <div class='text-end mt-5'>
            <button class='btn btn-primary text-capitalize momo me-0 me-sm-3 mb-3 mb-sm-0' id='momoQRBtn' type='button'>
                <i class='bi bi-qr-code-scan me-2'></i>
                <span>Thanh toán bằng MoMo QR Code</span>
            </button>
            <button class='btn btn-primary text-capitalize' id='momoATMBtn' type='button'>
                <i class='bi bi-credit-card me-2'></i>
                <span>Thanh toán bằng MoMo ATM</span>
            </button>
        </div>
    </div>
</div>