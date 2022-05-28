<?php
$navbarMenu = [
[
        'icon' => 'bi bi-person',
        'label' => 'Thông tin tài khoản',
        'root' => '',
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
    <nav>
        <?php
        $i = 0;
        foreach ($navbarMenu as $menuItem) {
            ['icon' => $icon, 'label' => $label, 'root' => $root] = $menuItem;
            echo "<div class='navbar-group'>";
                $link = "/tai-khoan/$root";
                echo "<h3 class='navbar-item'>
                        <i class='icn $icon me-2'></i>
                        <a href='$link'>$label</a>
                    </h3>";
            echo "</div>";
            $i = $i + 1;
        }
        ?>
    </nav>
</aside>
