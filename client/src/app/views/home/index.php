<!-- Banner -->
<?php require_once _DIR_ROOT . '/app/views/blocks/discount-banner.php'; ?>

<!-- show products -->
<?php require_once _DIR_ROOT . '/app/views/mixins/product-card.php'; ?>
<div class="container mt-4">
    <div class="catalog-wrapper mb-4">
        <h2 class="catalog-title">thịt, cá, hải sản</h2>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5 gx-4 gy-3">
            <?php
            foreach (range(1, 8) as $product) {
                echo "<div class='col'>";
                renderProductCard(1, "Đậu xanh rau muống", "https://cdn.tgdd.vn/Products/Images/7460/269315/bhx/loc-5-tang-1-banh-flan-anh-hong-hu-lon-100g-202203261404249484_300x300.jpg", 10000, 10, "Bó");
                echo "</div>";
            }
            ?>
        </div>
        <div class="catalog-more">
            Xem thêm <span>120</span> sản phẩm <i class="bi bi-caret-down-fill"></i>
        </div>
    </div>

</div>

<!-- Scroll top -->
<?php require_once _DIR_ROOT . '/app/views/blocks/scroll-top.php'; ?>