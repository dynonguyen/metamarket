<?php

$catalogs = [];
$catalogApiRes = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/catalogs');
extract($catalogApiRes);
if ($statusCode == 200) {
    $catalogs = $data;
    usort($catalogs, function ($cat1, $cat2) {
        return $cat1->name <=> $cat2->name;
    });
}

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
                $catalogName = $catalog->name;
                $catalogLink = $catalog->link;
                $categories = $catalog->categories;

                $categoryMenuXml = "";
                foreach ($categories as $category) {
                    $categoryName = $category->name;
                    $categoryLink = $category->link;

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