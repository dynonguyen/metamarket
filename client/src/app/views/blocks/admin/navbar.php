<?php
$navbarMenu = [
    [
        'icon' => 'bi bi-clipboard-data-fill',
        'label' => 'Quản lý nhân sự',
        'root' => 'don-hang',
        'list' => [
            [
                'to' => 'tat-ca',
                'label' => 'Danh sách shipper'
            ],
            [
                'to' => 'trong-thang',
                'label' => 'Thêm shipper'
            ]
        ]
    ],
    [
        'icon' => 'bi bi-box2-fill',
        'label' => 'Quản lý shop',
        'root' => 'san-pham',
        'list' => [
            [
                'to' => 'tat-ca',
                'label' => 'Danh sách shop trong hệ thống'
            ],
            [
                'to' => 'them',
                'label' => 'Shop chờ duyệt'
            ],
            [
                'to' => 'top',
                'label' => 'Thống kê doanh thu'
            ]
        ]
    ],
    [
        'icon' => 'bi bi-gear-fill',
        'label' => 'Quản lý khách hàng',
        'root' => 'quan-ly',
        'list' => [
            [
                'to' => 'thong-tin',
                'label' => 'Thông tin chung khách hàng'
            ],
            [
                'to' => 'thiet-lap',
                'label' => 'Cập nhật thông tin khách hàng'
            ]
        ]
    ],
    [
        'icon' => 'bi bi-bar-chart-fill',
        'label' => 'Thống kê',
        'root' => 'thong-ke',
        'list' => [
            [
                'to' => 'tong-quan',
                'label' => 'Phân tích tổng quan'
            ],
            [
                'to' => 'doanh-thu',
                'label' => 'Doanh thu'
            ]
        ]
    ]

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
                $link = "/kenh-ban-hang/$root/$to";
                $activeClass = $link === $_SERVER['REQUEST_URI'] ? 'active' : '';

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