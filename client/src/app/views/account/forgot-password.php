<div class='container py-5'>
    <form action='quen-mat-khau' method='GET' class='bg-white p-5' style='max-width: 375px; margin: 0 auto; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;'>
        <div class='text-center'>
            <h1 class='text-primary text-uppercase' style='font-size: 2.6rem;'>Quên mật khẩu</h1>
            <p class='text-gray my-2' style='font-size: 1.6rem;'>Nhập địa chỉ Email của bạn</p>
            <?php
            if (!empty($error)) {
                echo "<div class='alert alert-danger p-1 my-2' style='font-size: 1.5rem;'>$error</div>";
            }
            if (!empty($isSuccess)) {
                echo "<div class='alert alert-success p-1 my-2' style='font-size: 1.5rem;'>Yêu cầu thành công, vui lòng kiểm tra email của bạn.</div>";
            }
            ?>
            <input type='email' name='email' class='form-control form-control-lg my-4' style='font-size: 1.6rem;' maxlength="250" placeholder='your-email@gmail.com' required>
            <button type='submit' class='btn btn-lg btn-primary w-100' style='font-size: 1.6rem;' onclick="this.classList.add('disabled');">Tiếp tục</button>
        </div>
    </form>
</div>

<style>
    @media only screen and (min-width: 576px) {
        #footer {
            position: fixed;
            bottom: 0;
        }
    }
</style>