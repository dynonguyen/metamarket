<?php
require_once _DIR_ROOT . '/app/views/mixins/product-card.php';
require_once _DIR_ROOT . '/utils/Format.php';
require_once _DIR_ROOT . '/app/views/mixins/chat-box.php';
?>

<div class='py-4'>
    <div class='container'>
        <div class='row gx-4 gy-lg-0 gy-4 py-4 px-2 bg-white'>
            <div class='col col-12 col-lg-4'>
                <div class='shop-info-box p-3'>
                    <div class='vertical-center'>
                        <?php
                        $shopName = $shop['name'];
                        $shopAvt = empty($shop['logoUrl']) ? DEFAULT_SHOP_AVT : STATIC_FILE_URL . '/' . $shop['logoUrl'];
                        echo "<img src='$shopAvt' alt='$shopName' class='shop-avt'>";
                        ?>
                        <div class="ms-3">
                            <h1 class='fs-2 text-light'>
                                <?php echo $shop['name']; ?>
                            </h1>
                            <div class="text-gray fs-5 mt-2 vertical-center">
                                <?php
                                $onlineText = $shop['isOnline'] ? 'Đang hoạt động' : 'Offline';
                                $onlineClass = $shop['isOnline'] ? 'active' : '';
                                echo "<span>$onlineText</span><span class='dot ms-2 $onlineClass'></span>";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class='d-flex mt-3'>
                        <?php
                        $shopPhone = $shop['phone'];
                        echo "<a href='tel:$shopPhone' class='btn btn-outline-light w-50 fs-4'>  
                                <i class='bi bi-star-fill me-2'></i>
                                <span>Tư vấn trực tiếp</span>
                            </a>";
                        ?>
                        <button class='btn btn-outline-light w-50 ms-3 fs-4' id='showChatBtn'>
                            <i class='bi bi-chat-square-dots-fill me-2'></i>
                            <span>Chat</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class='col col-12 col-lg-8'>
                <div class='row h-100'>
                    <div class='col col-12 col-md-6 d-flex flex-column justify-content-around'>
                        <div class='d-flex fs-3'>
                            <i class='bi bi-telephone'></i>
                            <span class="mx-3">Số điện thoại: </span>
                            <span class='orange-color'><?php echo $shop['phone']; ?></span>
                        </div>
                        <div class='d-flex fs-3'>
                            <i class='bi bi-shop'></i>
                            <span class="mx-3">Sản phẩm: </span>
                            <span class='orange-color'><?php echo sizeof($products); ?></span>
                        </div>
                        <div class='d-flex fs-3'>
                            <i class='bi bi-star'></i>
                            <span class="mx-3">Đánh giá: </span>
                            <span class='orange-color'>Đang cập nhật</span>
                        </div>
                    </div>
                    <div class='col col-12 col-md-6 d-flex flex-column justify-content-around'>
                        <div class='d-flex fs-3'>
                            <i class='bi bi-basket'></i>
                            <span class="mx-3">Danh mục: </span>
                            <span class='orange-color'><?php echo $shop['category']; ?></span>
                        </div>
                        <div class='d-flex fs-3'>
                            <i class='bi bi-door-open'></i>
                            <span class="mx-3">Giờ mở cửa: </span>
                            <span class='orange-color'><?php echo $shop['openHours']; ?></span>
                        </div>
                        <div class='d-flex fs-3'>
                            <i class='bi bi-person-check'></i>
                            <span class="mx-3">Ngày tham gia: </span>
                            <span class='orange-color'>
                                <?php echo FormatUtil::ISOChangeTimeZone($shop['createdAt'], 'd-m-Y'); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='row bg-white my-4 py-4 px-2 gx-4'>
            <div class='col col-12'>
                <h2>Tất cả sản phẩm</h2>
            </div>
            <?php
            if (!empty($products)) {
                foreach ($products as $product) {
                    echo "<div class='col col-12 col-sm-6 col-md-4 col-lg-3'>";
                    renderProductCard($product->_id, $product->name, $product->avt, $product->price, $product->discount, $product->unit, $product->stock);
                    echo "</div>";
                }
            } else {
                echo '<p class="fs-3 py-2 text-center text-gray">Cửa hàng chưa có sản phẩm nào</p>';
            }
            ?>
        </div>
    </div>
</div>