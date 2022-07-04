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

                            echo "<tr data-id='$shop[shopId]' data-accountId='$shop[accountId]' data-bl='$shop[businessLicense]' data-fsc='$shop[foodSafetyCertificate]' data-status='$shop[status]'>";
                            echo "<td>$shop[name]</td>";
                            echo "<td>$shop[email]</td>";
                            echo "<td>$shop[phone]</td>";
                            echo "<td>$shop[supporterName]</td>";
                            echo "<td>$foundingDate</td>";
                            echo "<td>$shop[openHours]</td>";
                            echo "<td>$createdAt</td>";
                            echo "<td>$status</td>";
                            echo "<td><i class='bi bi-three-dots-vertical text-gray cursor-pointer shop-more' data-id='$shop[shopId]' data-bs-toggle='modal'  data-bs-target='#shopModal'></i></td>";
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

<div class="modal" id="shopModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="shopModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-2" id="shopModalLabel">Thông tin chi tiết của cửa hàng</h5>
                <button type="button" class="btn-close fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fs-3" style="max-height: 80vh; overflow: auto;">
                <div class="text-gray fs-2">Giấy phép kinh doanh</div>
                <img id="businessLicense" src='' class="w-100 h-100" alt='Business License'>

                <div class="text-gray fs-2 mt-3">Giấy chứng nhận vệ sinh an toàn thực phẩm</div>
                <img id="foodSafetyCertificate" src='' class="w-100 h-100" alt='Business License'>

                <div class="text-gray fs-2 mt-3">Trạng thái hoạt động</div>
                <select class="form-select fs-3" name='status' id='status'>
                    <option value='-1'>Khoá tài khoản</option>
                    <option value='0'>Chờ xét duyệt</option>
                    <option value='1'>Xét duyệt và hoạt động</option>
                </select>
            </div>
            <div class="modal-footer mt-auto">
                <button type="button" class="btn btn-secondary fs-3" data-bs-dismiss="modal">Đóng</button>
                <button type="button" id="updateBtn" class="btn btn-primary fs-3">Cập nhật</button>
            </div>
        </div>
    </div>
</div>