<!-- Banner -->
<!--?php require_once _DIR_ROOT . '/app/views/blocks/discount-banner.php'; ?>-->

<!-- show products -->
<!--php require_once _DIR_ROOT . '/app/views/mixins/product-card.php'; ?>-->
<div class="shipperinfor">
  <div>
    <div class="searchshipper">
      <input type="text" id="keyworshipper" placeholder="Nhập tên shipper">
      <button type="submit" class="searchButton" id='searchshipper'>
        <i class="bi bi-search" id="search"></i>
      </button>
    </div>
    <?php
    echo "<section>
   <div class='container'>
     <table class='table table-striped'>
       <thead>
         <tr class='header'>
           <th>Mã shipper
             <div>Mã shipper</div>
           </th>
           <th>Tên tài khoả
             <div>Tên tài khoản</div>
           </th>
           <th>Địa chỉ
             <div>Địa chỉ</div>
           </th>
           <th>Giấy phép lái xe
             <div>Giấy phép lái xe</div>
           </th>
           <th>CMND/CCCD
             <div>CMND/CCCD</div>
           </th>
           <th>Tình trạng
           <div>Tình trạng</div>
         </th>
         </tr>
       </thead>
       <tbody>";
    foreach ($shipperData as $item) {
      if ($item->status == 1)
        echo "
    <tr>
    <td>$item->shipperId</td>
    <td>$item->username</td>
    <td>$item->address</td>
    <td>$item->driverLicense</td>
    <td>$item->peopleId</td>
    <td>Hoạt động</td>
    </tr>
    ";
      else {
        echo "
    <tr>
    <td>$item->shipperId</td>
    <td>$item->username</td>
    <td>$item->address</td>
    <td>$item->driverLicense</td>
    <td>$item->peopleId</td>
    <td>Không hoạt động</td>
    </tr>
    ";
      }
    }
    echo "        </tbody>
  </table>
</div>
</section>";
    ?>
  </div>
  <?php require_once _DIR_ROOT . '/app/views/blocks/scroll-top.php'; ?>
</div>