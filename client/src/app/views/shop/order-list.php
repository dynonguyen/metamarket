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

                                echo "<tr data-order-id='$order->_id'>
                                        <td>$order->orderCode</td>
                                        <td>$orderDate</td>
                                        <td>$orderStatus</td>
                                        <td>$orderTotal</td>
                                        <td>$order->receiverName</td>
                                        <td>$order->receiverPhone</td>
                                        <td title='$order->note'>$note</td>
                                        <td class='text-end'>
                                            <i class='bi bi-pencil-fill me-3 cursor-pointer update-order-icon text-gray' 
                                                title='Cập nhật đơn hàng'
                                                data-id='$order->_id' data-order-status='$order->orderStatus'
                                                data-bs-toggle='modal' data-bs-target='#orderStatusModal'>
                                            </i>
                                            <i class='bi bi-eye-fill cursor-pointer show-detail-icon text-gray' 
                                                title='Xem chi tiết đơn hàng'
                                                data-id='$order->_id' data-code='$order->orderCode'
                                                data-bs-toggle='modal' data-bs-target='#orderDetailModal'>
                                            </i>
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

<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2 text-primary text-uppercase">Chi tiết đơn hàng <span id="orderCodeModal"></span></h5>
                <button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary fs-3" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2 text-primary text-uppercase">Cập nhật đơn hàng</h5>
                <button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class='error fs-3 text-danger py-3 d-none'>Bạn không thể cập nhật đơn hàng khi đã giao hàng</p>
                <label class="form-label fs-3 text-gray">Trạng thái đơn hàng</label>
                <select id='orderStatusSelect' class="fs-3 form-select">
                    <option value='2'>Chờ cửa hàng xử lý</option>
                    <option value='3'>Đã chuẩn bị hàng, chờ giao hàng</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary fs-3" data-bs-dismiss="modal">Huỷ bỏ</button>
                <button type="button" class="btn btn-primary fs-3" id="updateOrderBtn">Cập nhật</button>
            </div>
        </div>
    </div>
</div>