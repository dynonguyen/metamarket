<?php
require_once _DIR_ROOT . '/utils/Format.php';
require_once _DIR_ROOT . '/utils/Convert.php';
?>

<div class="container py-5" style="min-height: calc(100vh - 350px);">
    <div class='row g-2'>
        <div class="col col-12 col-lg-3 bg-white py-5 px-4">
            <h2>
                <i class='icon bi bi-person-circle me-2'></i>
                <?php echo $user->_get('fullname'); ?>
            </h2>
            <div class='mt-4'>
                <?php require_once _DIR_ROOT . '/app/views/blocks/user/navbar.php'; ?>
            </div>
        </div>

        <div class="col col-12 col-lg-9 p-4 bg-white fs-3">
            <h1 class="title text-primary">Đơn hàng của tôi</h1>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th scope="col">Mã ĐH</th>
                        <th scope="col">Ngày đặt</th>
                        <th scope="col">Trạng Thái</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Người nhận</th>
                        <th scope="col">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)) {
                        echo "<tr><td colspan='6' class='text-center py-3 text-gray'>Bạn chưa có đơn hàng nào</td></tr>";
                    } else {
                        foreach ($orders as $order) {
                            echo "<tr>";
                            echo '<td>' . $order->orderCode . '</td>';
                            echo '<td>' . FormatUtil::ISOChangeTimeZone($order->orderDate) . '</td>';
                            echo '<td>' . ConvertUtil::orderStatusToString($order->orderStatus) . '</td>';
                            echo '<td>' . FormatUtil::currencyVNDFormat($order->orderTotal) . '</td>';
                            echo '<td>' . $order->receiverName . '</td>';
                            echo '<td>' . $order->note . '</td>';
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>