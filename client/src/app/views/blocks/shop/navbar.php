<?php
$navbarMenu = [
    [
        'icon' => 'bi bi-clipboard-data-fill',
        'label' => 'Quản lý đơn hàng',
        'root' => 'don-hang',
        'list' => [
            [
                'to' => 'tat-ca',
                'label' => 'Tất cả'
            ],
            [
                'to' => 'trong-thang',
                'label' => 'Trong tháng'
            ],
            [
                'to' => 'chua-xu-ly',
                'label' => 'Chưa xử lý'
            ]
        ]
    ],
    [
        'icon' => 'bi bi-box2-fill',
        'label' => 'Quản lý sản phẩm',
        'root' => 'san-pham',
        'list' => [
            [
                'to' => 'tat-ca',
                'label' => 'Tất cả sản phẩm'
            ],
            [
                'to' => 'them',
                'label' => 'Thêm sản phẩm'
            ],
            [
                'to' => 'top',
                'label' => 'Sản phẩm bán chạy'
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
    ],
    [
        'icon' => 'bi bi-chat-dots-fill',
        'label' => 'CSKH, Đánh Giá',
        'root' => 'ho-tro',
        'list' => [
            [
                'to' => 'chat',
                'label' => 'Chăm sóc khách hàng'
            ],
            [
                'to' => 'danh-gia',
                'label' => 'Đánh giá của KH'
            ]
        ]
    ],
    [
        'icon' => 'bi bi-gear-fill',
        'label' => 'Quản lý shop',
        'root' => 'quan-ly',
        'list' => [
            [
                'to' => 'thong-tin',
                'label' => 'Thông tin'
            ],
            [
                'to' => 'thiet-lap',
                'label' => 'Thiết lập Shop'
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
                $link = "/kenh-ban-hang/$root/$to";
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