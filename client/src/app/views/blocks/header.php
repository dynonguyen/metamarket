<header>
    <nav class="container-fluid">
        <!-- Mobile navigation -->
        <div class="nav-mobile container d-none">
            <a href="/tai-khoan" class="vertical-center account-group">
                <i class="bi bi-person-circle me-2"></i>
                <?php
                global $user;

                if (!empty($user->_get('userId'))) {
                    $fullname = $fullname = substr($user->_get('fullname'), 0, 30);
                    echo "<div class='d-flex flex-column ms-2'>
                            <span>$fullname</span>
                            <a href='/account/logout' id='logout'>Đăng xuất</a>
                        </div>";
                } else {
                    echo "<span>Tài khoản</span>";
                }
                ?>
            </a>
            <a href="/gio-hang" class="vertical-center cart-group ms-5">
                <i class="bi bi-cart-fill me-2"></i>
                <span>Giỏ hàng <span id="quantity"></span></span>
            </a>
        </div>

        <!-- Desktop navigation -->
        <div class="container nav-wrapper">
            <a href="/" class="vertical-center logo-group">
                <img src="/public/assets/images/logo.svg" alt="MM Logo" class="logo">
                <strong class="logo-name desk">Meta<span class="orange-color">Market</span></strong>
                <strong class="logo-name mobile d-none">M<span class="orange-color">M</span></strong>
            </a>

            <div class="d-flex search-bar flex-grow-1 ms-5 mx-sm-5">
                <input type="text" class="form-control" placeholder="Nhập sản phẩm cần tìm ...">
                <i class="bi bi-search"></i>
            </div>

            <div class="d-flex right-side">
                <a href="/tai-khoan" class="vertical-center account-group">
                    <i class="bi bi-person-circle me-2"></i>
                    <?php
                    global $user;

                    if (!empty($user->_get('userId'))) {
                        $fullname = substr($user->_get('fullname'), 0, 15);
                        echo "<div class='d-flex flex-column ms-2'>
                            <span>$fullname</span>
                            <a href='/account/logout' id='logout'>Đăng xuất</a>
                        </div>";
                    } else {
                        echo "<span>Tài khoản</span>";
                    }
                    ?>
                </a>
                <a href="/gio-hang" class="vertical-center cart-group ms-5">
                    <i class="bi bi-cart-fill me-2"></i>
                    <span>Giỏ hàng <span id="quantity"></span></span>
                </a>
            </div>
        </div>
    </nav>
    <div class="sub-nav py-2">
        <div class="container flex-center-between">
            <?php require_once _DIR_ROOT . '/app/views/blocks/catalog.php'; ?>
            <a href="#" class="flex-center support-block cursor-pointer">
                <i class="bi bi-headset me-2"></i>
                <strong>Tư vấn trực tiếp</strong>
            </a>
        </div>
    </div>
</header>

<div class="margin-header"></div>