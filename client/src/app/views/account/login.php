<div class='container py-5'>
    <form id='form' method='POST' action='/account/postLogin'>
        <div class='text-center'>
            <?php $staticUrl = STATIC_FILE_URL;
            echo "<img class='form-logo' src='$staticUrl/assets/images/logo.svg' alt='Logo'>";
            ?>
        </div>
        <h1 class='text-center my-4 form-title'>Đăng nhập</h1>

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

        <button type='submit' id='submitBtn' class='btn btn-primary'>Đăng nhập</button>

        <?php echo "<a href='$googleLoginLink' class='login-gg-btn flex-center mt-3'>"; ?>
        <i class='bi bi-google me-3'></i>
        <span>Đăng nhập với Google</span>
        </a>

        <div class='other-options mt-5 pt-3'>
            <a href='/quen-mat-khau' class='orange-color'>Quên mật khẩu ?</a>
            <a href='/tai-khoan/dang-ky'>Đăng ký</a>
        </div>
    </form>
</div>