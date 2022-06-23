<?php
require_once _DIR_ROOT . '/utils/Format.php';
$fullname = $user->_get('fullname');
$phone = $user->_get('phone');
$gender = $user->_get('gender');
$dbo = FormatUtil::ISOChangeTimeZone($user->_get('dbo'), 'Y-m-d');
?>

<div class="container py-5">
    <div class='row g-2'>
        <div class="col col-12 col-lg-3 bg-white py-5 px-4">
            <h3 class="mb-3">
                <i class='icn bi bi-person-circle me-2'></i>
                <?php echo $fullname; ?>
            </h3>
            <div class='mt-5'>
                <?php require_once _DIR_ROOT . '/app/views/blocks/user/navbar.php'; ?>
            </div>
        </div>

        <div class="col col-12 col-lg-9 p-4 bg-white fs-3">
            <div class="title">
                <h1 class="hs">Hồ Sơ Của Tôi</h1>
                <div class="spe">Quản lý thông tin hồ sơ của bạn</div>
            </div>

            <?php
            if (!empty($formError)) {
                echo "<p id='formError' class='form-error mb-3 color-item'>$formError</p>";
            } else {
                echo "<p id='formError' class='form-error mb-3 color-item d-none'></p>";
            }
            ?>

            <form id='form' method='POST' class="row gy-4 gx-0 py-3" action='/account/postUpdateInfo'>
                <div class='col col-12'>
                    <label for='name' class="d-block mb-2 text-black-50">Họ tên</label>
                    <?php echo "<input class='form-control form-control-lg fs-3' id='name' type='text' name='name' value='$fullname' minlength='5' maxlength='50'/>"; ?>
                </div>
                <div class='col col-12'>
                    <label for='phone' class="d-block mb-2 text-black-50">Số điện thoại</label>
                    <?php echo "<input class='form-control form-control-lg fs-3' id='phone' type='tel' name='phone' value='$phone' minlength='10' maxlength='10' />"; ?>
                </div>
                <div class='col col-12'>
                    <label for='gender' class="d-block mb-2 text-black-50">Giới tính</label>
                    <?php
                    if ($gender == FEMALE) {
                        echo "<input class='gd' name='gender' type='radio' value='Nam'/><span class='sp'>Nam</span>
                                    <input class='gd' name='gender' type='radio' value='Nữ' checked/><span class='sp'>Nữ</spa>";
                    } else {
                        echo "<input class='gd' name='gender' type='radio' value='Nam' checked/><span class='sp'>Nam</span>
                                    <input class='gd' name='gender' type='radio' value='Nữ'/><span class='sp'>Nữ</spa>";
                    } ?>

                </div>
                <div class='col col-12'>
                    <label for='dbo' class="d-block mb-2 text-black-50">Ngày sinh</label>
                    <?php echo "<input id='dbo' class='form-control form-control-lg fs-3' name='dbo' type='date' value='$dbo' min='1952-01-01' max='2012-12-31' />"; ?>
                </div>
                <div class='submit col col-12'>
                    <button type="submit" class="btn btn-primary fs-3 submit-btn">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>