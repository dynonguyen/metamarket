<?php
require_once _DIR_ROOT . '/utils/Format.php';
global $shop;
?>

<div class='py-4'>
    <form action="/kenh-ban-hang/quan-ly/thiet-lap/post" method="POST" enctype='multipart/form-data' style="width: 45rem; max-width: 100%; margin: 0 auto;" class="fs-2 p-5 bg-white shadow rounded-3">
        <h1 class='shop-title'>Thiết lập thông tin cửa hàng</h1>

        <div class='flex-center mb-4 mt-5'>
            <?php
            $shopAvt = empty($shop->_get('logoUrl')) ? DEFAULT_SHOP_AVT : STATIC_FILE_URL . '/' . $shop->_get('logoUrl');
            echo "<img src='$shopAvt' id='avtImg' alt='Logo' class='rounded-circle' style='width: 15rem; height: 15rem;'>";
            ?>
        </div>

        <div class='mb-3'>
            <label for='avt' class='form-label text-gray fs-3'>Đổi ảnh đại diện</label>
            <input type='file' id="avt" name="avt" accept="images/*" class="form-control fs-3">
        </div>
        <div class='mb-3'>
            <label for='name' class='form-label text-gray fs-3'>Tên cửa hàng</label>
            <?php echo "<input type='text' name='name' class='form-control fs-3' required id='name' value='" . $shop->_get('name') . "'>"; ?>
        </div>
        <div class='mb-3'>
            <label for='phone' class='form-label text-gray fs-3'>Số điện thoại</label>
            <?php echo "<input type='text' name='phone' class='form-control fs-3' required id='phone' value='" . $shop->_get('phone') . "'>"; ?>
        </div>
        <div class='mb-3'>
            <label for='supporterName' class='form-label text-gray fs-3'>Người hỗ trợ</label>
            <?php echo "<input type='text' name='supporterName' class='form-control fs-3' required id='supporterName' value='" . $shop->_get('supporterName') . "'>"; ?>
        </div>
        <div class='mb-3'>
            <label for='openHours' class='form-label text-gray fs-3'>Giờ mở cửa</label>
            <?php echo "<input type='text' name='openHours' class='form-control fs-3' required id='openHours' value='" . $shop->_get('openHours') . "'>"; ?>
        </div>

        <div class='mt-5'>
            <button class='btn btn-primary w-100 fs-3 py-2 text-uppercase' type="submit" id="updateBtn">Cập nhật</button>
        </div>
    </form>
</div>