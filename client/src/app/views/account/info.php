<?php
    $fullname = $user->_get('fullname');
    $phone = $user->_get('phone');
    $gender = $user->_get('gender');
    $dbo = substr(str_replace('/','-', $user->_get('dbo')), 0, 10);
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
                echo "<form action='' method='post'><div class='cnt'>
                        <div class='cnt fullname'>
                        <label for='fname' class='lb'>Họ tên</label>
                        <input type='text' name='fname' value='$fullname'/>
                    </div>
                    <div class='cnt phone'>
                        <label for='fphone' class='lb'>Số điện thoại</label>
                        <input type='tel' name='fphone' value='$phone'/>
                    </div>
                    <div class='cnt gender'>
                        <label for='fgender' class='lb'>Giới tính</label>";
                    if($gender == FEMALE) {
                        echo "
                        <input class='gd' name='fgender' type='radio' value='Nam'/><span class='sp'>Nam</spa>
                        <input class='gd' name='fgender' type='radio' value='Nữ' checked/><span class='sp'>Nữ</spa>";
                    } else {
                        echo "
                        <input class='gd' name='fgender' type='radio' value='Nam' checked/><span class='sp'>Nam</span>
                        <input class='gd' name='fgender' type='radio' value='Nữ'/><span class='sp'>Nữ</spa>";
                    };
                    echo "</div>
                    <div class='cnt dbo'>
                        <label for='fdbo' class='lb'>Ngày sinh</label>
                        <input name='fdbo' type='date' value='$dbo'/>
                    </div>
                    <div class='cnt submit'>
                        <input id='up' type='submit' value='Cập nhật'/>
                    </div>
                    </div></div></form>";
        ?>
    </div>   
</div>