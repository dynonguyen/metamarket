<?php
require_once _DIR_ROOT . '/utils/Format.php';
require_once _DIR_ROOT . '/utils/Convert.php';
require_once _DIR_ROOT . '/app/views/mixins/pagination.php';
global $shipper;
?>

<div class='p-4'>
    <div class="bg-white p-4">
        <h1 class="admin-title">Danh sách đơn hàng của <?php print_r($shipper['data']->username) ?></h1>
        <div class='bg-white p-4'>
            <table class='table table-striped fs-3'>
                <thead>
                    <tr class='header'>
                        <th>Mã đơn hàng</th>
                        <th>Tên shop</th>
                        <th>Tên shipper</th>
                        <th>Tên người nhận</th>
                        <th>SĐT người nhận</th>
                        <th>Địa chỉ giao hàng</th>
                        <th>Ngày giao hàng</th>
                        <th>Phí vận chuyển</th>
                        <th>Ghi chú</th>
                        <th>Trạng thái đơn hàng</th>
                        <th>Cập nhật trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($orderData)) {
                        echo "<tr><td colspan=7' class='text-center text-danger py-4'>Không có đơn hàng nào</td></tr>";
                    } else {
                        for ($i = 0; $i < count($orderData); $i++) {
                            echo "<tr>";

                            echo "<td>";
                            print_r($orderData[$i]->orderCode);
                            echo "</td>";

                            echo "<td>";
                            print_r($shopName[$i]);
                            echo "</td>";

                            echo "<td>";
                            print_r($shipperName[$i]);
                            echo "</td>";

                            echo "<td>";
                            print_r($orderData[$i]->receiverName);
                            echo "</td>";

                            echo "<td>";
                            print_r($orderData[$i]->receiverPhone);
                            echo "</td>";

                            echo "<td>";
                            print_r($orderData[$i]->deliveryAddress->fullAddrStr);
                            echo "</td>";

                            echo "<td>";
                            print_r($orderData[$i]->orderDate);
                            echo "</td>";

                            echo "<td>";
                            print_r($orderData[$i]->transportFee);
                            echo " VNĐ";
                            echo "</td>";

                            echo "<td>";
                            print_r($orderData[$i]->note);
                            echo "</td>";

                            echo "<td>";
                            print_r(ConvertUtil::orderStatusToString($orderData[$i]->orderStatus));
                            echo "</td>";

                            $currentOrderId = $orderData[$i]->_id;
                            $currentOrderStatus = $orderData[$i]->orderStatus;
                            $currenOrderCode = $orderData[$i]->orderCode;
                            echo "<td>";
                            echo "<button type='button' class='btn btn-lg btn-outline-primary-accent update-btn' data-orderId='$currentOrderId' data-orderStatus='$currentOrderStatus' data-orderCode='$currenOrderCode'>Cập nhật</button>";
                            echo "</td>";

                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($totalPage)) {
            renderPagination($totalPage, $page);
        } ?>

    </div>
</div>