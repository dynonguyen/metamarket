<?php
require_once _DIR_ROOT . '/utils/Format.php';
require_once _DIR_ROOT . '/utils/Convert.php';
require_once _DIR_ROOT . '/app/views/mixins/pagination.php';
?>

<div class='p-4'>
    <div class="bg-white p-4">
        <h1 class="admin-title">Danh sách shipper</h1>
        <div class='bg-white p-4'>
            <table class='table table-striped fs-3'>
                <thead>
                    <tr class='header'>
                        <th>Mã shipper</th>
                        <th>Tên tài khoản</th>
                        <th>Địa chỉ</th>
                        <th>GPLX</th>
                        <th>CMND/CCCD</th>
                        <th>Tình trạng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $shippers = $shipperData->result->rows;
                    $total = $shipperData->result->count;
                    $page = $shipperData->page;
                    $pagesize = $shipperData->pagesize;
                    $totalPage = ceil($total / $pagesize);
                    foreach ($shippers as $shipper) {
                        $status = $shipper->status === 1 ? 'Đang hoạt động' : 'Không hoạt động';
                        echo "<tr>
                                <td>$shipper->shipperId</td>
                                <td>$shipper->username</td>
                                <td>$shipper->address</td>
                                <td>$shipper->driverLicense</td>
                                <td>$shipper->peopleId</td>
                                <td>$status</td>
                            </tr>";
                    } ?>
                </tbody>
            </table>
        </div>

        <?php renderPagination($totalPage, $page); ?>
    </div>
</div>