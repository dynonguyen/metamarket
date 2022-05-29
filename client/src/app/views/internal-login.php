<div class='container py-5'>
    <?php
    echo "<form id='form' method='POST' action='/InternalAccount/postLogin/$empType'>";
    ?>
    <div class='text-center'>
        <?php $staticUrl = STATIC_FILE_URL;
        echo "<img class='form-logo' src='$staticUrl/assets/images/logo.svg' alt='Logo'>";
        ?>
    </div>
    <h1 class='text-center my-4 form-title'><?php echo $empType === 'admin' ?  'Admin' : 'Shipper'; ?> | Đăng nhập</h1>

    <?php
    if (!empty($error)) {
        echo "<p id='formError' class='form-error mb-3'>$error</p>";
    } else {
        echo "<p id='formError' class='form-error mb-3 d-none'></p>";
    }
    ?>

    <input id='username' name='username' type='text' class='form-control form-control-lg' minlength="1" maxlength="150" placeholder='Tên đăng nhập'>
    <div class='password-field'>
        <input id='password' name='password' type='password' class='form-control form-control-lg' placeholder='Mật khẩu' maxlength="100">
        <i class='bi bi-eye-slash-fill password-icon'></i>
    </div>

    <button type='submit' id='submitBtn' class='btn btn-primary'>Đăng nhập</button>
    </form>
</div>

<style>
    #footer {
        position: fixed;
        bottom: 0;
        left: 0;
    }
</style>