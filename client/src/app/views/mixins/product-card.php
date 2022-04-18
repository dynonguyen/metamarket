<?php
function renderProductCard($_id, $name, $avt, $price, $discount, $unit)
{
    $productAvt = empty($avt) ? DEFAULT_PRODUCT_AVT : $avt;
    $discountRateXML = !empty($discount) ? "<label class='discount-rate'>-$discount%</label>" : "";
    $discountPrice = number_format(((100 + $discount) * $price) / 100, 0, ',', '.') . ' ₫';
    $discountPriceXML = !empty($discount) ? "<div class='discount'>$discountPrice</div>" :  "";
    $formattedPrice = number_format($price, 0, ',', '.') . ' ₫';

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
                        <strong>$formattedPrice</strong>
                        $discountRateXML
                    </div>
                    $discountPriceXML
                </div>
            </div>
            <div class='product-bottom'>
                <button class='btn btn-outline-primary-accent'>Thêm giỏ hàng</button>
            </div>
        </div>";
}
