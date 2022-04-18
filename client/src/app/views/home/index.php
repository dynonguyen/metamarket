<!-- Banner -->
<?php require_once _DIR_ROOT . '/app/views/blocks/discount-banner.php'; ?>

<!-- show products -->
<?php require_once _DIR_ROOT . '/app/views/mixins/product-card.php'; ?>

<?php
if (!empty($productData)) {
    usort($productData, function ($p1, $p2) {
        return $p2->products->total <=> $p1->products->total;
    });

    foreach ($productData as $item) {
        $catalogName = $item->catalogName;
        $productDocs = $item->products;
        $total = $productDocs->total;
        $page = $productDocs->page;
        $pageSize = $productDocs->pageSize;
        $products = $productDocs->docs;

        $numOfRest = $total - $page * $pageSize;
        $numOfRest = $numOfRest > 0 ? $numOfRest : 0;

        echo "<div class='container mt-5'>
                    <div class='catalog-wrapper mb-4'>
                        <h2 class='catalog-title'>$catalogName</h2>
                        <div class='row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-5 gx-4 gy-3'>";
        foreach ($products as $product) {
            echo "<div class='col'>";
            renderProductCard($product->_id, $product->name, $product->avt, $product->price, $product->discount, $product->unit);
            echo '</div>';
        }

        echo "</div>";
        if ($numOfRest) {
            echo "<div class='catalog-more mt-4'>
                Xem thêm <span>$numOfRest</span> sản phẩm <i class='bi bi-caret-down-fill'></i>
            </div>";
        }
        echo "</div></div>";
    }
}

?>

<!-- Scroll top -->
<?php require_once _DIR_ROOT . '/app/views/blocks/scroll-top.php'; ?>