<!-- Require bootstrap, utils/address-select.js, USER_SERVICE_API_URL -->

<div class='row gx-4 gy-3'>
    <div class='col col-12 col-md-6'>
        <select class="form-select" name='provinceId' id='province'>
            <option disabled selected value=''>Chọn Tỉnh / Thành</option>
        </select>
    </div>
    <div class='col col-12 col-md-6'>
        <select class="form-select disabled" name='districtId' id='district'>
            <option disabled selected value=''>Chọn Quận / Huyện</option>
        </select>
    </div>
    <div class='col col-12 col-md-6'>
        <select class="form-select disabled" name='wardId' id='ward'>
            <option disabled selected value=''>Chọn Xã / Phường</option>
        </select>
    </div>
    <div class='col col-12 col-md-6'>
        <input type='text' name="addrDetail" id='addrDetail' class='form-control form-control-lg' placeholder="Số nhà, tên đường">
    </div>
</div>