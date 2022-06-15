<?php
    require_once _DIR_ROOT.'/utils/Format.php';
    $fullname = $user->_get('fullname');
    $phone = $user->_get('phone');
    $gender = $user->_get('gender');
    $dbo = FormatUtil::ISOChangeTimeZone($user->_get('dbo'), 'Y-m-d');
?>

<div class="container_info">
    <div class=left>
        <?php
        echo "<div class='account'>
                <h3>
                    <i class='icn bi bi-person-circle'></i>
                    <span>Tài khoản của</span>
                    </br><b id='b'>$fullname</b>
                </h3>
            </div>";
        ?>                                                                                      
        <?php require_once _DIR_ROOT . '/app/views/blocks/user/navbar.php'; ?>
    </div> 
    <div class="content">
        <div class='itm'>
            <div class="title">
                <h1 class="hs">Hồ Sơ Của Tôi</h1>
                <div class="spe">Quản lý thông tin hồ sơ để bảo mật tài khoản</div>
            </div>
            <?php
                if (!empty($formError)) {
                    echo "<p id='formError' class='form-error mb-3 color-item'>$formError</p>";
                } else {
                    echo "<p id='formError' class='form-error mb-3 color-item d-none'></p>";
                }
            ?>
            <?php
                echo "<form id='form' method='POST' action='/account/postUpdateInfo'><div class='cnt'>
                        <div class='cnt fullname'>
                        <label for='name' class='lb'>Họ tên</label>
                        <input id='name' type='text' name='name' value='$fullname' minlength=5 maxlength=50/>
                    </div>
                    <div class='cnt phone'>
                        <label for='phone' class='lb'>Số điện thoại</label>
                        <input id='phone' type='tel' name='phone' value='$phone' minlength=10 maxlength=10/>
                    </div>
                    <div class='cnt gender'>
                        <label for='gender' class='lb'>Giới tính</label>";
                    if($gender == FEMALE) {
                        echo "
                        <input class='gd' name='gender' type='radio' value='Nam'/><span class='sp'>Nam</spa>
                        <input class='gd' name='gender' type='radio' value='Nữ' checked/><span class='sp'>Nữ</spa>";
                    } else {
                        echo "
                        <input class='gd' name='gender' type='radio' value='Nam' checked/><span class='sp'>Nam</span>
                        <input class='gd' name='gender' type='radio' value='Nữ'/><span class='sp'>Nữ</spa>";
                    };
                    echo "</div>
                    <div class='cnt dbo'>
                        <label for='dbo' class='lb'>Ngày sinh</label>
                        <input id= 'dbo' name='dbo' type='date' value='$dbo' min='1952-01-01' max='2012-12-31'/>
                    </div>
                    <div class='cnt submit'>
                        <input id='up' type='submit' value='Cập nhật'/>
                    </div>
                    </div></div></form>";
        ?>
    </div>   
</div>