<div class='py-4'>
    <div class='container bg-white px-4 py-5'>
        <h1 class='text-center text-uppercase fs-1 text-primary mb-4'>Đăng ký bán hàng</h1>
        <form action='/account/postShopRegister' id="shopRegisterForm" method='POST' enctype='multipart/form-data'>
            <h2 class="sub-title">Thông tin cửa hàng</h2>
            <div class='row g-4 mt-2 mb-4'>
                <div class='col col-12 col-md-6 col-lg-3'>
                    <label for="name" class="form-label">Tên cửa hàng</label>
                    <input type="text" name="name" class="form-control" id="name" autofocus>
                </div>
                <div class='col col-12 col-md-6 col-lg-3'>
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" id="phone">
                </div>
                <div class='col col-12 col-md-6 col-lg-3'>
                    <label for="supporterName" class="form-label">Tên người hỗ trợ</label>
                    <input type="text" name="supporterName" class="form-control" id="supporterName">
                </div>
                <div class='col col-12 col-md-6 col-lg-3'>
                    <label for="openHours" class="form-label">Giờ mở/đóng cửa</label>
                    <input type="text" name="openHours" class="form-control" id="openHours" placeholder="7AM - 8PM">
                </div>
                <div class='col col-12 col-md-6 col-lg-3'>
                    <label for=" foundingDate" class="form-label">Ngày thành lập</label>
                    <input type="date" name="foundingDate" class="form-control" id="foundingDate">
                </div>
                <div class='col col-12 col-md-6 col-lg-3'>
                    <label for="catalogId" class="form-label">Danh mục hàng hoá</label>
                    <select name='catalogId' id='catalogId' class='form-select'>
                        <option value="" selected disabled>Chọn danh mục</option>
                        <?php
                        if (!empty($catalogs)) {
                            foreach ($catalogs as $catalog) {
                                echo "<option value='$catalog->_id'>$catalog->name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class='col col-12 col-md-6 col-lg-3'>
                    <label for="logoUrl" class="form-label">Logo cửa hàng</label>
                    <input type="file" accept="images/*" name="logoUrl" class="form-control" id="logoUrl">
                </div>
            </div>

            <h2 class="sub-title">Thông tin tài khoản</h2>
            <div class='row g-4 mt-2 mb-4'>
                <div class='col col-12 col-md-6'>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="example@gmail.com">
                </div>
                <div class='col col-12 col-md-6'>
                    <label for="password" class="form-label">Mật khẩu</label>
                    <div class='password-field'>
                        <input id='password' name='password' type='password' class='form-control' placeholder="Ít nhất 8 ký tự">
                        <i class='bi bi-eye-slash-fill password-icon'></i>
                    </div>
                </div>
            </div>

            <h2 class="sub-title">Cam kết</h2>
            <p class="fs-4 orange-color">
                Vui lòng đọc kỹ chính sách của MetaMarket dành cho người bán hàng
                <b><a href='/dieu-khoan-dich-vu' target="_blank">Tại đây</a></b>
            </p>
            <div class='row gx-4 gy-5 mt-2 mb-5'>
                <div class='col col-12 col-md-6'>
                    <label for="businessLicense" class="form-label">Giấy phép kinh doanh</label>
                    <input type="file" accept="images/*" name="businessLicense" class="form-control" id="businessLicense">
                </div>
                <div class='col col-12 col-md-6'>
                    <label for="foodSafetyCertificate" class="form-label">Giấy chứng nhận an toàn thực phẩm</label>
                    <input type="file" accept="images/*" name="foodSafetyCertificate" class="form-control" id="foodSafetyCertificate">
                </div>
                <div class='col col-12 col-sm-4 form-checkbox'>
                    <label for="isOriginCommitment" class="form-label">Cam kết sản phẩm rõ nguồn gốc</label>
                    <div>
                        <input type="checkbox" name="isOriginCommitment" id="isOriginCommitment">
                    </div>
                </div>
                <div class='col col-12 col-sm-4 form-checkbox'>
                    <label for="isPolicyCommitment" class="form-label">Cam kết tuân thủ các chính sách</label>
                    <div>
                        <input type="checkbox" name="isPolicyCommitment" id="isPolicyCommitment">
                    </div>
                </div>
                <div class='col col-12 col-sm-4 form-checkbox'>
                    <label for="isCustomerCareCommitment" class="form-label">Cam kết chăm sóc khách hàng</label>
                    <div>
                        <input type="checkbox" name="isCustomerCareCommitment" id="isCustomerCareCommitment">
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <div class='row gx-4'>
                <div class='col col-lg-4 ms-auto'>
                    <button class='btn btn-primary text-uppercase w-100' id="submitBtn">Đăng ký</button>
                </div>
            </div>
        </form>
    </div>
</div>