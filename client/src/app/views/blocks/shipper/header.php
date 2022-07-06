<header class="container-fluid flex-center-between w-100">
    <div class='vertical-center'>
        <a href="/" class="vertical-center logo-group">
            <?php
            $staticUrl = STATIC_FILE_URL;
            echo "<img src='$staticUrl/assets/images/logo.svg' alt='MM Logo' class='logo me-2' width='100%' height='100%'>";
            ?>
            <strong class="logo-name desk">Meta<span class="orange-color">Market</span></strong>
            <strong class="logo-name mobile d-none">M<span class="orange-color">M</span></strong>
        </a>
        <div class="sub-logo ms-3">Kênh vận chuyển</div>
    </div>
    </div>
    <div class='vertical-center'>
        <i class='bi bi-grid-3x3-gap toggle-navbar-icon' id="toggleNavbar" title="Đóng/mở menu"></i>
        <button class='btn btn-logout ms-4'>
            <a href='/account/logout'>Đăng Xuất</a>
        </button>
    </div>
</header>