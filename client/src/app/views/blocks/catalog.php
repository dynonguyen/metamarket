<?php
require_once _DIR_ROOT . '/app/models/Category.php';
require_once _DIR_ROOT . '/app/models/Catalog.php';

// dummy data
$catalogs = [
    new CatalogModel(1, 'Rau củ, trái cây', 'raucu-traicay', [
        new CategoryModel(1, 1, 'Rau củ', 'rau-cu'),
        new CategoryModel(1, 2, 'Trái cây', 'trai-cay')
    ]),
    new CatalogModel(2, 'Thịt, trứng, hải sản', 'thit-trung-haisan', [
        new CategoryModel(2, 3, 'Thịt', 'thit'),
        new CategoryModel(2, 4, 'Trứng', 'trung'),
        new CategoryModel(2, 5, 'Hải sản', 'hai-san')
    ])
];

?>

<div class="catalog-wrapper">
    <div class="dropdown">
        <div class="catalog-label dropdown-toggle" id="catalogDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
            <div class=" flex-center cursor-pointer">
                <i class="bi bi-list me-2"></i>
                <strong class="label">Danh mục sản phẩm</strong>
            </div>
        </div>

        <!-- Catalog menu -->
        <ul class="dropdown-menu catalog-menu" aria-labelledby="catalogDropdownBtn">
            <?php
            foreach ($catalogs as $catalog) {
                $catalogName = $catalog->__get('name');
                $catalogLink = $catalog->__get('link');
                $categories = $catalog->__get('categories');

                $categoryMenuXml = "";
                foreach ($categories as $category) {
                    $categoryName = $category->__get('name');
                    $categoryLink = $category->__get('link');

                    $categoryMenuXml .= "<li class='category-item'>";
                    $categoryMenuXml .= "<a href='/category/$categoryLink'>$categoryName</a></li>";
                }

                echo ("<li class='catalog-item'>
                        <div class='catalog-item-label'>
                            <a href='/catalog/$catalogLink'>$catalogName</a>
                            <i class='bi bi-chevron-down'></i>
                        </div>
                        <ul class='category-menu'>$categoryMenuXml</ul>
                    </li>");
            }
            ?>

        </ul>
    </div>
</div>