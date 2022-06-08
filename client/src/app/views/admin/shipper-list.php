<?php
require_once _DIR_ROOT . '/utils/Format.php';
require_once _DIR_ROOT . '/utils/Convert.php';
require_once _DIR_ROOT . '/app/views/mixins/pagination.php';
?>

<div class="container">
    <div class="py-5 flex-center fs-3">
        <input type="text" class="form-control form-control-lg fs-3 rounded-0 border-2" style="max-width: 300px; height: 40px;" id="keywordInput" placeholder="Nhập tên shipper">
        <button type="submit" class="btn btn-primary rounded-0" style="height: 38px;" id='searchshipper'>
            <i class="bi bi-search" id="search"></i>
        </button>
    </div>

    <table class='table table-striped fs-3'>
        <thead>
            <tr class='header'>
                <th>Mã shipper
                </th>
                <th>Tên tài khoản
                </th>
                <th>Địa chỉ
                </th>
                <th>GPLX
                </th>
                <th>CMND/CCCD
                </th>
                <th>Tình trạng
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $shippers = $shipperData->result->rows;
            $total = $shipperData->result->count;
            $page = $shipperData->page;
            $pagesize = $shipperData->pagesize;
            $totalpage = ceil($total / $pagesize);
            foreach ($shippers as $item) {
                if ($item->status == 1)
                    echo "<tr>
                    <td>$item->shipperId</td>
                    <td>$item->username</td>
                    <td>$item->address</td>
                    <td>$item->driverLicense</td>
                    <td>$item->peopleId</td>
                    <td>Hoạt động</td>
                </tr>";
                else {
                    echo "<tr>
                    <td>$item->shipperId</td>
                    <td>$item->username</td>
                    <td>$item->address</td>
                    <td>$item->driverLicense</td>
                    <td>$item->peopleId</td>
                    <td>Không hoạt động</td>
                </tr>";
                }
            } ?></tbody>
    </table>

    <?php
    echo "<div class='col col-12'>";
    renderPagination($totalpage, $page);
    echo "</div>";
    ?>
</div>
<?php require_once _DIR_ROOT . '/app/views/blocks/scroll-top.php'; ?>
</div>