<?php
require_once _DIR_ROOT . '/utils/Format.php';
require_once _DIR_ROOT . '/utils/Convert.php';
require_once _DIR_ROOT . '/app/views/mixins/pagination.php';
?>

<div class='p-4'>
    <div class="bg-white p-4">
        <h1 class="admin-title">Danh sách đơn hàng</h1>
        <div class='bg-white p-4'>
            <table class='table table-striped fs-3'>
                <thead>
                    <tr class='header'>
                        <th>Mã đơn hàng</th>
                        <th>Tên cửa hàng</th>
                        <th>Tên shipper</th>
                        <th>Tên người nhận</th>
                        <th>SĐT người nhận</th>
                        <th>Ngày giao hàng</th>
                        <th>Trạng thái thanh toán</th>
                        <th>Phương thức thanh toán</th>
                        <th>Phí vận chuyển</th>
                        <th>Trạng thái đơn hàng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>
</div>