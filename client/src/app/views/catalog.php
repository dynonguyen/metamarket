<div class='pt-4'></div>

<?php require_once _DIR_ROOT . '/app/views/blocks/breadcrumb.php'; ?>
<?php require_once _DIR_ROOT . '/app/views/mixins/product-card.php'; ?>
<?php
require_once _DIR_ROOT . '/app/views/mixins/toast.php';
renderToast('Đã thêm vào giỏ hàng');
?>

<style>
    .catalog-more {
        padding: 1.2rem 1rem;
        border-top: solid 1px var(--mm-light);
        text-align: center;
        font-size: 1.5rem;
        cursor: pointer;
        font-weight: 500;
        color: var(--bs-orange);
    }
</style>

<?php
function renderOption($value, $label, $selectedValue)
{
    if ($value === $selectedValue) {
        echo "<option value='$value' selected>$label</option>";
    } else {
        echo "<option value='$value'>$label</option>";
    }
}
?>

<div class='container bg-white mb-4'>
    <?php if (!empty($productDocs) && $productDocs->total > 0) { ?>
        <div class='d-flex justify-content-end mb-3'>
            <select id='sort' style="max-width: 250px; font-size: 1.5rem" class='form-select'>
                <?php
                renderOption('', 'Sắp xếp (mặc định)', $sort);
                renderOption('price', 'Giá tăng dần', $sort);
                renderOption('-price', 'Giá giảm dần', $sort);
                ?>
            </select>
        </div>

        <?php
        echo "<div id='productList' class='row g-4'>";
        $products = $productDocs->docs;
        $total = $productDocs->total;
        $page = $productDocs->page;
        $pageSize = $productDocs->pageSize;
        $rest = $total - $page * $pageSize;

        foreach ($products as $p) {
            echo "<div class='col'>";
            renderProductCard($p->_id, $p->name, $p->avt, $p->price, $p->discount, $p->unit, $p->stock);
            echo "</div>";
        }
        echo  "</div>";

        if ($rest > 0) {
            echo "<div id='loadMore' class='catalog-more mt-4' data-page='$page' data-size='$pageSize' data-id='$catalogId'>";
            echo "Xem thêm <span class='rest'>$rest</span> sản phẩm <i class='bi bi-caret-down-fill'></i><span class='spinner-border d-none'></span>";
            echo "</div>";
        }
        ?>
    <?php } else {
        echo "<p class='text-center text-gray pb-4' style='font-size: 1.6rem'>Không tìm thấy sản phẩm nào</p>";
    } ?>
</div>