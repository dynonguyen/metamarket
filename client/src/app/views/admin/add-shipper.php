<div class="container py-5 h-100 add-shipper">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                    <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 fs-1">Thêm Shipper</h3>
                    <form action="them-shipper/post" id="addShipper" method='POST' class="fs-3">
                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <div class="form-outline">
                                    <label class="form-label" for="username">Tên tài khoản: <span class='required'>(*)</span></label>
                                    <input type="text" id="username" name="username" class="form-control form-control-lg fs-3" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-outline">
                                    <label class="form-label" for="address">Địa chỉ của shipper: <span class='required'>(*)</span> </label>
                                    <input type="text" id="address" name="address" class="form-control form-control-lg fs-3" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-outline">
                                    <label class="form-label" for="driverLicense">Mã giấy phép lái xe: <span class='required'>(*)</span> </label>
                                    <input type="text" id="driverLicense" name="driverLicense" class="form-control form-control-lg fs-3" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-outline">
                                    <label class="form-label" for="peopleId">CMND/CCCD: <span class='required'>(*)</span></label>
                                    <input type="text" id="peopleId" name="peopleId" class="form-control form-control-lg fs-3" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-outline">
                                    <label class="form-label" for="password">Mật khẩu ban đầu: <span class='required'>(*)</span></label>
                                    <input type="password" id="password" name="password" class="form-control form-control-lg fs-3" />
                                </div>
                            </div>
                            <div class="col-12">
                                <input class="btn btn-primary btn-lg py-2 text-uppercase w-100 ms-auto fs-3" type="submit" value="Thêm mới" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($isError)) {
    require_once _DIR_ROOT . '/app/views/mixins/toast.php';
    if ($isError) {
        renderToast('Thêm shipper thất bại', true, true, true);
    } else {
        renderToast('Thêm shipper thành công', true, true, false);
    }

    echo "<script>setTimeout(() => { window.location.href = '/kenh-quan-ly/shipper/them-shipper' }, 2000)</script>";
}
?>