<?php
require_once _DIR_ROOT . '/utils/Image.php';
require_once _DIR_ROOT . '/utils/Format.php';

function renderProductCard($_id, $name, $avt, $price, $discount, $unit, $exp, $stock = 1, $purchaseTotal = 0)
{
    $productAvt = empty($avt) ? DEFAULT_PRODUCT_AVT : ImageUtil::toThumbnail(STATIC_FILE_URL . "/$avt");
    $discountRateXML = !empty($discount) ? "<label class='discount-rate'>-$discount%</label>" : "";
    $formattedPrice = FormatUtil::currencyVNDFormat($price);
    $discountPriceXML = !empty($discount) ? "<div class='discount'>$formattedPrice</div>" :  "";
    $discountPrice = !empty($discount) ? FormatUtil::currencyVNDFormat($price * (100 - $discount) / 100) : $formattedPrice;
    $expDate = FormatUtil::ISOChangeTimeZone($exp, 'd-m-Y');

    echo "<div class='product-card'>
            <div class='product-top'>
                <img class='product-avt' src='$productAvt' alt='$name' title='$name'>
            </div>
            <div class='product-content'>
                <h3 class='product-name'>$name</h3>
                <div class='product-unit'>ĐVT: $unit</div>
                <div class='product-price'>
                    <div class='vertical-center'>
                        <strong>$discountPrice</strong>
                        $discountRateXML
                    </div>
                    $discountPriceXML
                </div>
            </div>
            <div class='product-bottom'>
                <p class='text-gray fs-4'>HSD: $expDate</p>
                <p class='text-gray fs-4 mb-3'>Đã bán ($purchaseTotal) - Tồn kho: $stock</p>
                <button class='btn btn-outline-primary-accent' data-id='$_id' data-bs-toggle='modal' data-bs-target='#exampleModal-$_id'>Chỉnh sửa</button>
            </div>
        </div>";
}
