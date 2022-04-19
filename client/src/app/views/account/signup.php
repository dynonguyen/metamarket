<div class='container py-5'>
    <form id='form' method='POST' action='/account/postSignup'>
        <div class='text-center'>
            <img class='form-logo' src='/public/assets/images/logo.svg' alt='Logo'>
        </div>
        <h1 class='text-center my-4 form-title'>Tạo tài khoản</h1>

        <?php
        if (!empty($formError)) {
            echo "<p id='formError' class='form-error mb-3'>$formError</p>";
        } else {
            echo "<p id='formError' class='form-error mb-3 d-none'></p>";
        }
        ?>

        <input id='email' name='email' type='text' class='form-control form-control-lg' minlength="1" maxlength="150" placeholder='Email'>
        <div class='password-field'>
            <input id='password' name='password' type='password' class='form-control form-control-lg' placeholder='Mật khẩu' maxlength="100">
            <i class='bi bi-eye-slash-fill password-icon'></i>
        </div>
        <div class='password-field'>
            <input id='confirmPwd' type='password' class='form-control form-control-lg' placeholder='Nhập lại mật khẩu' maxlength="100">
            <i class='bi bi-eye-slash-fill password-icon'></i>
        </div>
        <input id='fullname' name='fullname' type='text' class='form-control form-control-lg' placeholder='Họ tên' maxlength="50">

        <button type='submit' id='submitBtn' class='btn btn-primary'>Đăng ký</button>

        <div class='other-options mt-5 pt-3'>
            <a href='/' class='orange-color'>Đăng ký bán hàng</a>
            <a href='/tai-khoan/dang-nhap'>Đăng nhập</a>
        </div>
    </form>
</div>