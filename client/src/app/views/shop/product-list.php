<?php
require_once _DIR_ROOT . '/app/views/mixins/product-card-shop.php';
require_once _DIR_ROOT . '/app/views/mixins/pagination.php';
?>

<div class='py-4'>
    <div class='container p-4 bg-white'>
        <h1 class='shop-title'>Danh sách sản phẩm</h1>

        <div class='vertical-center mb-5 justify-content-end'>
            <div class="me-3">
                <label for="sort" class="form-label ps-2 fs-3 text-gray">Sắp xếp</label>
                <select id='sort' class='form-select fs-3'>
                    <option value='' selected>Mặc định</option>
                    <option value='price'>Giá tăng dần</option>
                    <option value='-price'>Giá giảm dần</option>
                    <option value='name'>Theo tên A-Z</option>
                    <option value='-name'>Theo tên Z-A</option>
                    <option value='createdAt'>Mới - cũ</option>
                    <option value='-createdAt'>Cũ - mới</option>
                    <option value='purchaseTotal'>Số lượng bán tăng dần</option>
                    <option value='-purchaseTotal'>Số lượng bán giảm dần</option>
                </select>
            </div>
            <div class="me-3">
                <label for="filter" class="form-label ps-2 fs-3 text-gray">Lọc</label>
                <select id='filter' class='form-select fs-3'>
                    <option value='' selected>Tất cả sản phẩm</option>
                    <option value='exp'>Sản phẩm hết hạn sử dụng</option>
                    <option value='discount'>Có khuyến mãi</option>
                    <option value='no-discount'>Không khuyến mãi</option>
                    <option value='no-stock'>Hết hàng trong kho</option>
                </select>
            </div>
        </div>

        <div class='row g-4'>
            <?php if (empty($productDocs->docs)) { ?>
                <div class='col col-12 text-center'>
                    <p class="fs-2 py-4 text-gray">Không tìm thấy sản phẩm nào</p>
                    <a href='/kenh-ban-hang/san-pham/them'>
                        <button class='btn btn-accent fs-3'>
                            Thêm sản phẩm ngay
                        </button>
                    </a>
                </div>
            <?php } else {
                $total = (int)$productDocs->total;
                $page = (int)$productDocs->page;
                $pageSize = (int)$productDocs->pageSize;
                $totalPage = ceil($total / $pageSize);
                $products = $productDocs->docs;
                foreach ($products as $p) {
                    echo "<div class='col col-12 col-md-6 col-lg-4 col-xl-3'>";
                    renderProductCard($p->_id, $p->name, $p->avt, $p->price, $p->discount, $p->unit, $p->exp, $p->stock, $p->purchaseTotal);
                    echo "</div>";
                }

                echo "<div class='col col-12'>";
                renderPagination($totalPage, $page);
                echo "</div>";
            } ?>
        </div>
    </div>
</div>