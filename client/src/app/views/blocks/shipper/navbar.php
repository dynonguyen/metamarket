<?php
$navbarMenu = [
    [
        'icon' => 'bi bi-box2-fill',
        'label' => 'Quản lý đơn hàng',
        'root' => 'don-hang',
        'list' => [
            [
                'to' => 'tat-ca',
                'label' => 'Tất cả đơn hàng'
            ],
            [
                'to' => 'chua-xac-nhan',
                'label' => 'ĐH chưa có shipper'
            ],
            [
                'to' => 'cap-nhat',
                'label' => 'Cập nhật đơn hàng'
            ]
        ]
    ],
];
?>

<aside id="navbar">
    <nav>
        <?php
        foreach ($navbarMenu as $menuItem) {
            ['icon' => $icon, 'label' => $label, 'list' => $list, 'root' => $root] = $menuItem;
            echo "<div class='navbar-group'>";
            echo "<h3 class='navbar-label'>
                    <i class='$icon me-2'></i>
                    <span>$label</span>
                </h3>";
            echo "<ul>";
            foreach ($list as $item) {
                ['to' => $to, 'label' => $itemLabel] = $item;
                $link = "/kenh-van-chuyen/$root/$to";
                $activeClass = str_contains($_SERVER['REQUEST_URI'], $link) ? 'active' : '';

                echo "<li class='navbar-item $activeClass'>
                        <a href='$link'>$itemLabel</a>
                    </li>";
            }
            echo "</ul>";
            echo "</div>";
        }

        ?>
    </nav>
</aside>