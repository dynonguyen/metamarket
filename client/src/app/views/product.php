<div class='pt-4'></div>

<?php require_once _DIR_ROOT . '/app/views/blocks/breadcrumb.php'; ?>
<?php require_once _DIR_ROOT . '/utils/Image.php'; ?>
<?php
require_once _DIR_ROOT . '/app/views/mixins/toast.php';
renderToast('Thêm vào giỏ hàng thành công');
?>
<?php $staticUrl = STATIC_FILE_URL; ?>

<?php
$productId = $product->_id;
$productName = $product->name;
$productAvt = $product->avt;
$numOfMfg = round((strtotime($product->mfg) - time()) / 86400);
$productPrice = number_format($product->price, 0, ',', '.') . ' ₫';
$productPriceDiscount = number_format($product->price * (100 + $product->discount) / 100, 0, ',', '.') . ' ₫';
?>

<div class='product-wrapper mb-4'>
    <!-- Product's basic info -->
    <div class='container p-4'>
        <div class='product'>
            <div class='row gx-3 gy-4'>
                <!-- Photo -->
                <div class='col col-12 col-md-6 col-lg-5 product-photo'>
                    <div class='avt p-4'>
                        <?php echo "<img id='photoAvt' src='$staticUrl/$productAvt' alt='$productName'>"; ?>
                    </div>

                    <?php if (!empty($productDetail)) {
                        $photos = $productDetail->photos;
                    ?>
                        <div class='photos'>
                            <?php
                            $avtThumb = ImageUtil::toThumbnail("$staticUrl/$productAvt");
                            echo "<div class='photo-item active'>
                                <img src='$avtThumb'>
                            </div>";

                            foreach ($photos as $photoSrc) {
                                $photoThumb = ImageUtil::toThumbnail("$staticUrl/$photoSrc");
                                echo "<div class='photo-item'>
                                    <img src='$photoThumb'>
                                </div>";
                            }

                            ?>
                        </div>
                    <?php } ?>
                </div>

                <!-- info -->
                <div class='col col-12 col-md-6 col-lg-7'>
                    <h1 class="product-name">
                        <?php echo $productName; ?>
                    </h1>

                    <div class='vertical-center my-3 product-stats'>
                        <div class='avg-rate orange-color'>
                            <strong>
                                <?php echo number_format($product->rateAvg, 1, '.', ""); ?>
                            </strong>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <span class='total-review px-4 mx-4'>
                            <strong>
                                <?php echo $product->reviewTotal; ?>
                            </strong>&nbsp;Đánh giá
                        </span>
                        <span class="total-purchase">
                            <strong>
                                <?php echo $product->purchaseTotal; ?>
                            </strong>&nbsp;Đã bán
                        </span>
                    </div>

                    <strong class='product-code'>SKU&nbsp;<?php echo $product->code; ?></strong>
                    <div class="product-exp">HSD còn <?php echo $numOfMfg; ?> ngày</div>

                    <div class='product-price vertical-center'>
                        <span class='price'><?php echo $productPrice; ?></span>
                        <?php
                        if ($product->discount > 0) {
                            echo "<strike class='discount'>$productPriceDiscount</strike>";
                            echo "<span class='discount-rate'>-$product->discount%</span>";
                        }
                        ?>
                    </div>

                    <div class='product-unit'>
                        <label>Đơn vị</label>
                        <span><?php echo $product->unit; ?></span>
                    </div>

                    <?php if ($product->stock > 0) { ?>
                        <div class='vertical-center mt-5'>
                            <label>Số lượng</label>
                            <span class='product-stock'>
                                <strong><?php echo $product->stock; ?></strong> sản phẩm có sẵn
                            </span>
                        </div>

                        <div class='action-btn'>
                            <?php echo "<button class='btn btn-outline-accent me-3 add-cart' data-id='$product->_id' data-stock='$product->stock' data-price='$product->price' id='addCartBtn'>"; ?>
                            <i class='bi bi-cart-plus-fill me-3'></i>
                            <span>Thêm giỏ hàng</span>
                            </button>
                            <button class='btn btn-primary' id='buyBtn'>Mua ngay</button>
                        </div>
                    <?php } else { ?>
                        <div class='action-btn text-center'>
                            <button class='btn btn-primary w-100'>
                                <i class='bi bi-telephone-fill me-3'></i>
                                <span>Liên hệ</span>
                            </button>
                        </div>
                    <?php } ?>

                    <div class='commitment vertical-center'>
                        <?php echo "<img class='me-2' src='$staticUrl/assets/images/logo.svg' alt='MM Logo'>"; ?>
                        <span>MetaMarket Cam Kết</span>
                        <p class="ms-5 text-gray">Sản phẩm an toàn, hỗ trợ nhiệt tình</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product details -->
    <div class='container mt-4'>
        <div class='product-detail'>
            <div class='row gx-3 gy-4'>
                <div class='col col-12 col-md-6 col-lg-8'>
                    <h2 class="title">Mô tả sản phẩm</h2>
                    <div class='product-desc'>
                        <?php
                        if (!empty($productDetail)) {
                            echo $productDetail->desc;
                        } else {
                            echo "<p class='updating'>Đang cập nhật ...</p>";
                        }
                        ?>
                    </div>
                </div>
                <div class='col col-12 col-md-6 col-lg-4'>
                    <h2 class="title">Thông tin sản phẩm</h2>
                    <ul class='product-infos'>
                        <?php
                        if (!empty($productDetail)) {
                            $infos = $productDetail->infos;
                            foreach ($infos as $info) {
                                echo "<li>";
                                echo "<label>$info->label</label>";
                                echo "<span>$info->detail</span>";
                                echo "</li>";
                            }
                        } else {
                            echo "<p class='updating'>Đang cập nhật ...</p>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop info -->
    <?php if (!empty($shop)) { ?>
        <div class='container mt-4 p-4'>
            <div class='row'>
                <div class='shop-info d-flex col col-12 col-md-4'>
                    <?php
                    $shopLogo = $shop->logoUrl ?? DEFAULT_SHOP_AVT;
                    echo "<img class='logo' src='$shopLogo' alt='$shop->name'>";
                    ?>
                    <div class='d-flex flex-column justify-content-center ms-4'>
                        <h3 class='shop-name mb-3'><?php echo $shop->name; ?></h3>
                        <div class='shop-actions'>
                            <button class='btn btn-outline-accent me-2'>
                                <i class='bi bi-chat-square-dots-fill'></i>
                                <span>Chat ngay</span>
                            </button>
                            <button class='btn btn-outline-secondary'>
                                <i class='bi bi-shop'></i>
                                <span>
                                    <?php echo "<a href='/cua-hang/$shop->shopId'>Xem shop</a>"; ?>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class='col col-12 col-md-8 mt-3 mt-md-0 shop-summary flex-center-between'>
                    <span>Giờ mở cửa&nbsp;&nbsp;
                        <span class='orange-color'><?php echo $shop->openHours; ?></span>
                    </span>
                    <span class="mx-2">Danh mục&nbsp;&nbsp;
                        <span class='orange-color'><?php echo $product->catalogId->name; ?></span>
                    </span>
                    <span>Tham gia&nbsp;&nbsp;
                        <span class='orange-color'><?php echo date_format(date_create($shop->createdAt), 'd-m-Y'); ?></span>
                    </span>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Review -->
    <div class='container mt-4 p-4'>
        <h2 class='title'>Đánh giá sản phẩm</h2>
        <?php if (!empty($reviews)) {
            $countStars = [0, 0, 0, 0, 0];
            foreach ($reviews as $review) {
                $rating = (int)$review->rate;
                if ($rating > 0 && $rating < 6)
                    $countStars[$rating - 1] += 1;
            }
        ?>
            <div class='review-summary row p-4'>
                <div class='col col-4'>
                    <span class='total'>
                        <b><?php echo number_format($product->rateAvg, 1, '.', ""); ?></b> trên 5
                    </span>
                    <div class='d-flex'>
                        <?php
                        $star = (int)round($product->rateAvg);
                        for ($i = 1; $i <= $star; ++$i) {
                            echo "<i class='bi bi-star-fill'></i>";
                        }
                        for ($i = 1; $i <= 5 - $star; ++$i) {
                            echo "<i class='bi bi-star'></i>";
                        }
                        ?>

                    </div>
                </div>
                <div class='review-detail col col-8 flex-center-between flex-grow-1'>
                    <?php
                    echo "<span>Tất cả ($product->reviewTotal)</span>";
                    echo "<span>5 sao ($countStars[4])</span>";
                    echo "<span>4 sao ($countStars[3])</span>";
                    echo "<span>3 sao ($countStars[2])</span>";
                    echo "<span>2 sao ($countStars[1])</span>";
                    echo "<span>1 sao ($countStars[0])</span>";
                    ?>
                </div>
            </div>

            <ul class='comment'>
                <?php
                foreach ($reviews as $review) {
                    $cusFullname = $review->customerInfo->fullname;
                    $cusName = $review->isAnonymous ? $cusFullname[0] . '******' . $cusFullname[strlen($cusFullname) - 1] : $cusFullname;
                    $rate = (int)$review->rate;
                    $content = $review->content;

                    echo "<li class='comment-item'>
                            <div class='comment-name'>$cusName</div>
                            <div class='comment-rating'>";

                    for ($i = 1; $i < $rate; ++$i) {
                        echo "<i class='bi bi-star-fill'></i>";
                    }
                    for ($i = 1; $i <= 5 - $rate; ++$i) {
                        echo "<i class='bi bi-star'></i>";
                    }

                    echo "</div>
                            <div class='comment-date'>15-02-2022 15:10</div>
                            <p class='comment-content'>$content</p>
                        </li>";
                }
                ?>
            </ul>
        <?php } else { ?>
            <p class='updating mb-4'>Chưa có đánh giá nào</p>
        <?php } ?>

        <h2 class='title'>Bình luận</h2>
        <p class='alert alert-danger fs-4 d-none' id="commentError"></p>
        <form action='/danh-gia-san-pham' method="POST" id="commentForm">
            <input type='number' class="d-none" name="rate" value="0">
            <?php echo "<input name='productId' class='d-none' value='$productId'>"; ?>

            <div class='comment-box'>
                <textarea class='input form-control' name="content" rows="5" placeholder="Nhập một bình luận" required id="commentContent"></textarea>

                <?php
                global $user;
                if (empty($user->_get('fullname'))) {
                    echo "<div class='d-flex mt-3'>
                    <input type='text' name='fullname' placeholder='Họ tên (bắt buộc)' required class='form-control form-control-lg me-2'>
                    <input type='email' name='email' placeholder='Email (bắt buộc)' required class='form-control form-control-lg'>
                </div>";
                }
                ?>

                <div class='row mt-4'>
                    <div class='col col-6 col-md-4 d-flex align-items-center orange-color'>
                        <i class='bi bi-star comment-star' data-star="1"></i>
                        <i class='bi bi-star comment-star' data-star="2"></i>
                        <i class='bi bi-star comment-star' data-star="3"></i>
                        <i class='bi bi-star comment-star' data-star="4"></i>
                        <i class='bi bi-star comment-star' data-star="5"></i>
                    </div>
                    <div class="col col-6 col-md-4 form-check vertical-center">
                        <input class="form-check-input me-3" name="isAnonymous" type="checkbox" id="anonymous">
                        <label class="form-check-label" for="anonymous">Ẩn danh</label>
                    </div>
                    <div class='col col-12 col-md-4 mt-4 mt-md-0'>
                        <button class='btn btn-primary w-100' id="submitReviewBtn" type="submit" form="commentForm">Gửi</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Shop's other products -->
    <?php if (!empty($otherProducts)) { ?>
        <div class='container mt-4 p-4'>
            <h2 class='title'>Sản phẩm khác của shop</h2>
            <div class='d-flex shop-products'>
                <?php
                require_once _DIR_ROOT . '/app/views/mixins/product-card.php';
                foreach ($otherProducts as $oProduct) {
                    renderProductCard($oProduct->_id, $oProduct->name, $oProduct->avt, $oProduct->price, $oProduct->discount, $oProduct->unit);
                }
                ?>
            </div>
        </div>
    <?php } ?>
</div>