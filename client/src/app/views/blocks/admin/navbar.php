<?php
$navbarMenu = [
    [
        'icon' => 'bi bi-person-lines-fill',
        'label' => 'Quản lý nhân sự',
        'root' => 'shipper',
        'list' => [
            [
                'to' => 'tat-ca',
                'label' => 'Tất cả shipper'
            ],
            [
                'to' => 'them-shipper',
                'label' => 'Thêm shipper'
            ]
        ]
    ],
    [
        'icon' => 'bi bi-bag-fill',
        'label' => 'Quản lý cửa hàng',
        'root' => 'cua-hang',
        'list' => [
            [
                'to' => 'tat-ca',
                'label' => 'Tất cả các cửa hàng'
            ],
            [
                'to' => 'cho-duyet',
                'label' => 'Cửa hàng chờ duyệt'
            ]
        ]
    ],
    [
        'icon' => 'bi bi-chat-dots-fill',
        'label' => 'Quản lý khách hàng',
        'root' => 'khach-hang',
        'list' => [
            [
                'to' => 'tat-ca',
                'label' => 'Tất cả khách hàng'
            ],
            [
                'to' => 'danh-gia',
                'label' => 'Đánh giá của KH'
            ]
        ]
    ],
    [
        'icon' => 'bi bi-gear-fill',
        'label' => 'Thống kê',
        'root' => 'thong-ke',
        'list' => [
            [
                'to' => 'doanh-thu',
                'label' => 'Doanh thu'
            ],
            [
                'to' => 'cua-hang',
                'label' => 'Cửa hàng'
            ],
            [
                'to' => 'khach-hang',
                'label' => 'Khách hàng'
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
                $link = "/kenh-quan-ly/$root/$to";
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