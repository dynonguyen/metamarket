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
            <h2>
                <i class='icon bi bi-person-circle me-2'></i>
                <?php echo $fullname; ?>
            </h2>
            <div class='mt-4'>
                <?php require_once _DIR_ROOT . '/app/views/blocks/user/navbar.php'; ?>
            </div>
        </div>

        <div class="col col-12 col-lg-9 p-4 bg-white fs-3">
            <div class="title">
                <h1 class="text-primary">Hồ Sơ Của Tôi</h1>
                <div>Quản lý thông tin hồ sơ của bạn</div>
            </div>

            <?php
            if (!empty($formError)) {
                echo "<p id='formError' class='form-error my-3 text-danger'>$formError</p>";
            } else {
                echo "<p id='formError' class='form-error my-3 text-danger d-none'></p>";
            }
            ?>

            <form id='form' method='POST' class="row gy-4 gx-0 py-3" action='/user/postUpdateInfo'>
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
                    <div class='d-flex gap-3'>
                        <?php if ($gender == FEMALE) { ?>
                            <div class="form-check">
                                <input class="form-check-input" name='gender' id="gender" type='radio' value='Nam' />
                                <label class="form-check-label" for="gender">Nam</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name='gender' id="gender" type='radio' value='Nữ' checked />
                                <label class="form-check-label" for="gender">Nữ</label>
                            </div>
                        <?php } else { ?>
                            <div class="form-check">
                                <input class="form-check-input" name='gender' id="gender" type='radio' value='Nam' checked />
                                <label class="form-check-label" for="gender">Nam</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name='gender' id="gender" type='radio' value='Nữ' />
                                <label class="form-check-label" for="gender">Nữ</label>
                            </div>
                        <?php } ?>
                    </div>
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