<div class="container py-5 h-100 add-shipper">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                    <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Thêm Shipper</h3>
                    <form action="them-shipper/post" id="addShipper" method='POST' enctype='multipart/form-data'>

                        <div class="row">
                            <div class="col-md-6 mb-4">

                                <div class="form-outline">
                                    <label class="form-label" for="shipperid">Shipper ID: <span class='required'>(*)</span></label>
                                    <input type="text" id="shipperid" name="shipperid" class="form-control form-control-lg" />
                                </div>

                            </div>
                            <div class="col-md-6 mb-4">

                                <div class="form-outline">
                                    <label class="form-label" for="username">Tên tài khoản: <span class='required'>(*)</span></label>
                                    <input type="text" id="username" name="username" class="form-control form-control-lg" />
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">

                                <div class="form-outline">
                                    <label class="form-label" for="address">Địa chỉ của shipper: <span class='required'>(*)</span> </label>
                                    <input type="text" id="address" name="address" class="form-control form-control-lg" />
                                </div>

                            </div>
                            <div class="col-md-6 mb-4">

                                <div class="form-outline">
                                    <label class="form-label" for="driverlicense">Mã giấy phép lái xe: <span class='required'>(*)</span> </label>
                                    <input type="text" id="driverlicense" name="driverlicense" class="form-control form-control-lg" />
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">

                                <div class="form-outline">
                                    <label class="form-label" for="peopleid">CMND/CCCD: <span class='required'>(*)</span></label>
                                    <input type="text" id="peopleid" name="peopleid" class="form-control form-control-lg" />
                                </div>

                            </div>
                            <div class="col-md-6 mb-4">

                                <div class="form-outline">
                                    <label class="form-label" for="password">Mật khẩu ban đầu: <span class='required'>(*)</span></label>
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" />
                                </div>

                            </div>
                        </div>

                        <div class="text-center btn-addshipper">
                            <input class="btn btn-primary btn-lg" type="submit" value="Thêm mới" />
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