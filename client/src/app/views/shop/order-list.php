<?php
require_once _DIR_ROOT . '/utils/Format.php';
require_once _DIR_ROOT . '/utils/Convert.php';
require_once _DIR_ROOT . '/app/views/mixins/pagination.php';
?>

<div class='py-4'>
    <div class='container-fluid'>
        <div class='bg-white py-4'>
            <h1 class="shop-title">Danh sách đơn hàng</h1>

            <div class='px-5 mt-5 table-responsive-sm'>
                <table class="table table-striped table-hover fs-3">
                    <thead>
                        <tr>
                            <th scope="col">Mã ĐH</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Người nhận</th>
                            <th scope="col">SĐT người nhận</th>
                            <th scope="col">Ghi chú</th>
                            <th scope="col" class="text-end">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($orderDocs) && sizeof($orderDocs->docs)) {
                            $orders = $orderDocs->docs;

                            foreach ($orders as $order) {
                                $orderDate = date_format(date_create($order->orderDate), 'H:i d-m-Y');
                                $orderTotal = FormatUtil::currencyVNDFormat($order->orderTotal);
                                $orderStatus = ConvertUtil::orderStatusToString($order->orderStatus);
                                $MAX_NOTE_LEN = 15;
                                $note = strlen($order->note) > $MAX_NOTE_LEN ? substr($order->note, 0, $MAX_NOTE_LEN) . "..." : $order->note;

                                echo "<tr>
                                        <td>$order->orderCode</td>
                                        <td>$orderDate</td>
                                        <td>$orderStatus</td>
                                        <td>$orderTotal</td>
                                        <td>$order->receiverName</td>
                                        <td>$order->receiverPhone</td>
                                        <td title='$order->note'>$note</td>
                                        <td class='text-end'>
                                            <i class='bi bi-pencil-fill me-3 cursor-pointer update-icon text-gray' title='Cập nhật đơn hàng'></i>
                                            <i class='bi bi-eye-fill cursor-pointer show-detail-icon text-gray' title='Xem chi tiết đơn hàng'></i>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo '<tr><td colspan="8"><p class="text-center text-gray fs-3 py-3">Bạn chưa có đơn hàng nào</p></td></tr>';
                        } ?>
                    </tbody>
                </table>

                <?php if (!empty($orderDocs)) {
                    $total = (int)$orderDocs->total;
                    $pageSize = (int)$orderDocs->pageSize;
                    $page = (int)$orderDocs->page;
                    echo "<div class='mt-4'></div>";
                    renderPagination(ceil($total / $pageSize), $page);
                } ?>
            </div>
        </div>
    </div>
</div>