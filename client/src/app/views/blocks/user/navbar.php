<?php
$navbarMenu = [
    [
        'icon' => 'bi bi-person',
        'label' => 'Thông tin tài khoản',
        'root' => 'thong-tin',
    ],
    [
        'icon' => 'bi bi-clipboard-data',
        'label' => 'Quản lý đơn hàng',
        'root' => 'don-hang',
    ],
    [
        'icon' => 'bi bi-compass',
        'label' => 'Địa chỉ giao hàng',
        'root' => 'dia-chi',
    ],
    [
        'icon' => 'bi bi-gear',
        'label' => 'Thông báo',
        'root' => 'thong-bao',
    ]
];
?>
<aside id="navbar">
    <nav class="d-flex flex-column gap-4">
        <?php
        foreach ($navbarMenu as $menuItem) {
            ['icon' => $icon, 'label' => $label, 'root' => $root] = $menuItem;
            echo "<div class='navbar-group'>";
            $link = "/tai-khoan/$root";
            $activeClass = str_contains($_SERVER['REQUEST_URI'], $link) ? 'active' : '';

            echo "<h3 class='navbar-item $activeClass'>
                        <i class='icon $icon me-2'></i>
                        <a href='$link'>$label</a>
                    </h3>";
            echo "</div>";
        }
        ?>
    </nav>
</aside>