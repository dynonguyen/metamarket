<?php require_once _DIR_ROOT . '/utils/Format.php'; ?>

<div class='py-4'>
    <div style="width: 45rem; max-width: 100%; margin: 0 auto;" class="fs-2 p-5 bg-white shadow rounded-3">
        <h1 class='shop-title'>Thông tin cửa hàng</h1>

        <div class='flex-center mb-4 mt-5'>
            <?php
            $shopAvt = empty($shopInfo['logoUrl']) ? DEFAULT_SHOP_AVT : STATIC_FILE_URL . '/' . $shopInfo['logoUrl'];
            echo "<img src='$shopAvt' alt='Logo' class='rounded-circle' style='width: 15rem; height: 15rem;'>";
            ?>
        </div>
        <div class="flex-center-between mt-3">
            <span class='text-gray'>Tên cửa hàng: </span>
            <span class='text-end ms-3'><?php echo $shopInfo['name']; ?></span>
        </div>
        <div class="flex-center-between mt-3">
            <span class='text-gray'>Email: </span>
            <span class='text-end ms-3'><?php echo $shopInfo['email']; ?></span>
        </div>
        <div class="flex-center-between mt-3">
            <span class='text-gray'>Số điện thoại: </span>
            <span class='text-end ms-3'><?php echo $shopInfo['phone']; ?></span>
        </div>
        <div class="flex-center-between mt-3">
            <span class='text-gray'>Tên người hỗ trợ: </span>
            <span class='text-end ms-3'><?php echo $shopInfo['supporterName']; ?></span>
        </div>
        <div class="flex-center-between mt-3">
            <span class='text-gray'>Danh mục sản phẩm: </span>
            <span class='text-end ms-3'><?php echo $shopInfo['catalog']; ?></span>
        </div>
        <div class="flex-center-between mt-3">
            <span class='text-gray'>Giờ mở cửa: </span>
            <span class='text-end ms-3'><?php echo $shopInfo['openHours']; ?></span>
        </div>
        <div class="flex-center-between mt-3">
            <span class='text-gray'>Ngày thành lập: </span>
            <span class='text-end ms-3'>
                <?php echo FormatUtil::ISOChangeTimeZone($shopInfo['foundingDate'], 'd-m-Y'); ?>
            </span>
        </div>
        <div class='mt-5'>
            <a href='/kenh-ban-hang/quan-ly/thiet-lap'>
                <button class='btn btn-primary w-100 fs-3 py-2 text-uppercase'>
                    <span>Chỉnh sửa thông tin</span>
                    <i class='bi bi-gear-fill ms-2'></i>
                </button>
            </a>
        </div>
    </div>
</div>