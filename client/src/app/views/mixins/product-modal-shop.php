<?php
require_once _DIR_ROOT . '/utils/Image.php';
require_once _DIR_ROOT . '/utils/Format.php';
// global $shop;

function renderProductModal($catalogs, $_id, $code, $name, $avt, $price, $discount, $unit, $mfg, $exp, $stock, $origin, $brand, $desc, $shopCatalogId, $shopCategoryId)
{
    $productAvt = empty($avt) ? DEFAULT_PRODUCT_AVT : ImageUtil::toThumbnail(STATIC_FILE_URL . "/$avt");
    $mfgDate = FormatUtil::ISOChangeTimeZone($mfg, 'Y-m-d');
    $expDate = FormatUtil::ISOChangeTimeZone($exp, 'Y-m-d');

    echo "
        <!-- Modal -->
        <div class='modal fade' id='exampleModal-$_id' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog modal-xl'>
            <div class='modal-content'>
            <div class='modal-header'>
                <h2 class='modal-title' id='exampleModalLabel'>Cập nhật sản phẩm</h2>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
            <div class='bg-white p-4'>
            <h2 class='shop-title'>$name</h2>
            <!-- Avt -->
            <div class='flex-center mb-4 mt-5'>
            <img src='$productAvt' id='avtImg' name='avt' alt='Logo' class='rounded-circle' style='width: 15rem; height: 15rem;'>
            </div>
        
            <form action='/kenh-ban-hang/san-pham/cap-nhat/post' id='updateProductForm' method='POST' enctype='multipart/form-data'>
                <h2 class='sub-title'>Cập nhật thông tin cơ bản</h2>
                <div class='row g-4'>   
                    <!-- Product Id -->
                    <input type='hidden' name='_id' value='" . $_id . "'>
                    <!-- Product code -->
                    <input type='hidden' name='code' value='" . $code . "'>
                
                    <!-- Name -->
                    <div class='col col-12 col-md-4 col-lg-3'>
                        <label for='name' class='form-label'>Tên <span class='required'>(*)</span></label>
                        <input type='text' name='name' class='form-control' id='name' value='" . $name . "'>
                    </div>
                    <!-- Catalog, category -->
                    <div class='col col-12 col-md-4 col-lg-3'>
                        <label for='catalog' class='form-label'>Danh mục <span class='required'>(*)</span></label>
                        <select class='form-select' name='catalog'>
                            <option disabled selected>Chọn danh mục</option>";
    foreach ($catalogs as $catalog) {
        $categories = $catalog->categories;
        $catalogId = $catalog->_id;
        $catalogName = $catalog->name;

        echo "<optgroup label='$catalogName'>";
        foreach ($categories as $cate) {
            $cateId = $cate->id;
            $cateName = $cate->name;
            if ($shopCatalogId->_id == $catalogId && $shopCategoryId) {
                echo "<option value='$catalogId/$cateId' selected>$cateName</option>";
            } else {
                echo "<option value='$catalogId/$cateId'>$cateName</option>";
            }
        }
        echo "</optgroup>";
    }
    echo "</select>
                    </div>
                    <!-- Price -->
                    <div class='col col-12 col-md-4 col-lg-3'>
                        <label for='price' class='form-label'>Giá <span class='required'>(*)</span></label>
                        <input type='number' name='price' min='0' class='form-control' id='price' value='" . $price . "'>
                    </div>
                    <!-- Stock -->
                    <div class='col col-12 col-md-4 col-lg-3'>
                        <label for='stock' class='form-label'>SL tồn kho <span class='required'>(*)</span></label>
                        <input type='number' name='stock' min='0' class='form-control' id='stock' value='" . $stock . "'>
                    </div>
                    <!-- Discount -->
                    <div class='col col-12 col-md-4 col-lg-3'>
                        <label for='discount' class='form-label'>Khuyến mại (%)</label>
                        <input type='number' name='discount' min='0' max='100' class='form-control' id='discount' value='" . $discount . "'>
                    </div>
                    <!-- Unit -->
                    <div class='col col-12 col-md-4 col-lg-3'>
                        <label for='unit' class='form-label'>Đơn vị <span class='required'>(*)</span></label>
                        <input type='text' name='unit' class='form-control' id='unit' placeholder='VD: Cái' value='" . $unit . "'>
                    </div> 
                    <!-- MFG -->
                    <div class='col col-12 col-md-4 col-lg-3'>
                        <label for='mfg' class='form-label'>Ngày sản xuất <span class='required'>(*)</span></label>
                        <input type='date' class='form-control' id='mfg' disabled value='" . $mfgDate . "'>
                    </div>
                    <!-- EXP -->
                    <div class='col col-12 col-md-4 col-lg-3'>
                        <label for='exp' class='form-label'>Ngày hết hạn <span class='required'>(*)</span></label>
                        <input type='date' class='form-control' id='exp' disabled value='" . $expDate . "'>
                    </div>          
        
                    <!-- Avt -->
                    <div class='col col-12 col-md-4 col-lg-3'>
                        <label for='avt' class='form-label'>Đổi ảnh đại diện</label>
                        <input name='avt' class='form-control' type='file' id='avt' accept='image/*'>
                    </div>
                </div>
        
                <h2 class='sub-title mt-5'>Thông tin chi tiết</h2>
                <div class='row g-4'>
                    <!-- Origin -->
                    <div class='col col-12 col-md-4 col-lg-3'>
                        <label for='origin' class='form-label'>Xuất xứ <span class='required'>(*)</span></label>
                        <input type='text' name='origin' class='form-control' id='origin' placeholder='VD: Việt Nam' value='" . $origin . "'>
                    </div>
        
                    <!-- Branch -->
                    <div class='col col-12 col-md-4 col-lg-3'>
                        <label for='brand' class='form-label'>Thương hiệu <span class='required'>(*)</span></label>
                        <input type='text' name='brand' class='form-control' id='brand' value='" . $brand . "'>
                    </div>
                </div>
        
                
                <h2 class='sub-title mt-5'>Thêm hình ảnh sản phẩm</h2>
                <input name='photos[]' class='form-control' multiple type='file' id='photos' accept='image/*'>
        
                <h2 class='sub-title mt-5'>Mô tả sản phẩm</h2>
                <textarea class='validate-ignore' cols='20' id='desc-$_id' name='desc'>$desc</textarea>
                <input id='descInput' type='text' class='d-none' value='" . $desc . "'/>
        
                <!-- submit button -->
                <div class='text-end mt-4'>
                    <button class='btn btn-primary btn-lg' type='submit' type='button' id='submitBtn'>
                        Cập nhật sản phẩm
                    </button>
                </div>
            </form>
        </div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Đóng</button>
            </div>
            </div>
        </div>
        </div>";
}
