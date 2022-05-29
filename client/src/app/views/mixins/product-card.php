<?php
require_once _DIR_ROOT . '/utils/Image.php';
require_once _DIR_ROOT . '/utils/Format.php';

// Required product-card.css
function renderProductCard($_id, $name, $avt, $price, $discount, $unit, $stock = 1)
{
    $productAvt = empty($avt) ? DEFAULT_PRODUCT_AVT : ImageUtil::toThumbnail(STATIC_FILE_URL . "/$avt");
    $discountRateXML = !empty($discount) ? "<label class='discount-rate'>-$discount%</label>" : "";
    $formattedPrice = FormatUtil::currencyVNDFormat($price);
    $discountPriceXML = !empty($discount) ? "<div class='discount'>$formattedPrice</div>" :  "";
    $discountPrice = !empty($discount) ? FormatUtil::currencyVNDFormat($price * (100 - $discount) / 100) : $formattedPrice;
    $actionBtn = $stock >= 1 ?
        "<button class='btn btn-outline-primary-accent add-cart' data-id='$_id' data-price='$price' data-stock='$stock' data-discount='$discount'>Thêm giỏ hàng</button>"
        : "<button class='btn btn-accent disabled'>Tạm hết hàng</button>";

    echo "<div class='product-card'>
            <a href='/san-pham/$_id' class='product-top'>
                <img class='product-avt' src='$productAvt' alt='$name' title='$name'>
            </a>
            <div class='product-content'>
                <a class='product-name' href='/san-pham/$_id' title='$name'>
                    <h3 class='product-name'>$name</h3>
                </a>
                <div class='product-unit'>ĐVT: $unit</div>
                <div class='product-price'>
                    <div class='vertical-center'>
                        <strong>$discountPrice</strong>
                        $discountRateXML
                    </div>
                    $discountPriceXML
                </div>
            </div>
            <div class='product-bottom'>$actionBtn</div>
        </div>";
}
