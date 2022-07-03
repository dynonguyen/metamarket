<?php
require_once _DIR_ROOT . '/utils/Format.php';
require_once _DIR_ROOT . '/utils/Convert.php';
require_once _DIR_ROOT . '/app/views/mixins/pagination.php';
?>

<div class='p-4'>
    <div class='bg-white p-4'>
        <h1 class='admin-title'>Quản lý danh sách cửa hàng</h1>
        <div class='table-responsive-lg'>
            <table class="table table-striped fs-3">
                <thead>
                    <tr>
                        <th scope="col">Tên CH</th>
                        <th scope="col">Email</th>
                        <th scope="col">SĐT</th>
                        <th scope="col">NV hỗ trợ</th>
                        <th scope="col">Ngày thành lập</th>
                        <th scope="col">Giờ mở cửa</th>
                        <th scope="col">Ngày tham gia</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($shops)) {
                        echo "<tr><td colspan=7' class='text-center text-danger py-4'>Không tìm thấy cửa hàng nào</td></tr>";
                    } else {
                        foreach ($shops as $shop) {
                            $foundingDate = FormatUtil::ISOChangeTimeZone($shop['foundingDate'], 'd-m-Y');
                            $createdAt = FormatUtil::ISOChangeTimeZone($shop['createdAt'], 'd-m-Y');
                            $status = ConvertUtil::accountStatusToString($shop['status']);

                            echo "<tr>";
                            echo "<td>$shop[name]</td>";
                            echo "<td>$shop[email]</td>";
                            echo "<td>$shop[phone]</td>";
                            echo "<td>$shop[supporterName]</td>";
                            echo "<td>$foundingDate</td>";
                            echo "<td>$shop[openHours]</td>";
                            echo "<td>$createdAt</td>";
                            echo "<td>$status</td>";
                            echo "<td><i class='bi bi-three-dots-vertical text-gray cursor-pointer'></i></td>";
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