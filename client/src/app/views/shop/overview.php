<?php require_once _DIR_ROOT . '/utils/Format.php'; ?>
<div class='py-4'>
    <div class='container p-5 bg-white'>
        <h1 class='shop-title'>Tổng quan về kinh doanh</h1>

        <div class='row mt-4 g-4'>
            <div class='col col-12 col-md-6 col-lg-4 col-xl-3'>
                <div class='overview-item bg-primary'>
                    <h3 class='title'>Doanh thu</h3>
                    <strong class='quantity'>
                        <?php echo FormatUtil::currencyVNDFormat((int)$stats['revenue']); ?>
                    </strong>
                </div>
            </div>
            <div class='col col-12 col-md-6 col-lg-4 col-xl-3'>
                <div class='overview-item bg-warning'>
                    <h3 class='title'>Đơn hàng</h3>
                    <strong class='quantity'>
                        <?php echo $stats['order']; ?>
                    </strong>
                </div>
            </div>
            <div class='col col-12 col-md-6 col-lg-4 col-xl-3'>
                <div class='overview-item bg-success'>
                    <h3 class='title'>Đánh giá</h3>
                    <strong class='quantity'>
                        <?php echo $stats['review']; ?>
                    </strong>
                </div>
            </div>
            <div class='col col-12 col-md-6 col-lg-4 col-xl-3'>
                <div class='overview-item bg-info'>
                    <h3 class='title'>Sản phẩm</h3>
                    <strong class='quantity'>
                        <?php echo $stats['product']; ?>
                    </strong>
                </div>
            </div>
        </div>
    </div>
</div>