<div class='container py-5'>
    <form id="form" action='/thuc-hien-thay-doi-mat-khau' method='POST' class='bg-white p-5' style='max-width: 375px; margin: 0 auto; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;'>
        <h1 class='text-primary text-uppercase text-center mb-4' style='font-size: 2.6rem;'>Thay đổi mật khẩu</h1>
        <div class='alert alert-danger mb-4 p-2 d-none' id='error' style='font-size: 1.5rem;'></div>

        <?php echo "<input id='email' class='form-control form-control-lg disabled mb-4' disabled style='font-size: 1.6rem;' placeholder='$email' />"; ?>
        <?php echo "<input name='code' value='$code' class='d-none' />"; ?>

        <input id='password' type="password" name="password" class='form-control form-control-lg mb-4' style='font-size: 1.6rem;' maxlength='100' placeholder='Mật khẩu mới' required autofocus>
        <input id='confirmPassword' type="password" class='form-control form-control-lg mb-4' style='font-size: 1.6rem;' maxlength='100' placeholder='Nhập lại mật khẩu' required>

        <button type='submit' class='btn btn-lg btn-primary w-100' style='font-size: 1.6rem;'>Xác nhận</button>
    </form>
</div>

<style>
    @media only screen and (min-width: 576px) {
        #footer {
            position: fixed;
            bottom: 0;
        }

        .form-control,
        .form-label {
            font-size: 1.6rem;
        }
    }
</style>