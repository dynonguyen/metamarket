<?php
require_once _DIR_ROOT . '/utils/Format.php';
require_once _DIR_ROOT . '/utils/Convert.php';
require_once _DIR_ROOT . '/app/views/mixins/pagination.php';
?>
<div class="shipperinfor">
  <div class="searchshipper">
    <input type="text" id="keywordInput" placeholder="Nhập tên shipper">
    <button type="submit" id='searchshipper'>
      <i class="bi bi-search" id="search"></i>
    </button>
  </div>
  <?php
  echo "
   <div class='container'>
     <table class='table table-striped'>
       <thead>
         <tr class='header'>
           <th>Mã shipper
           </th>
           <th>Tên tài khoả
           </th>
           <th>Địa chỉ
           </th>
           <th>Giấy phép lái xe
           </th>
           <th>CMND/CCCD
           </th>
           <th>Tình trạng
         </th>
         </tr>
       </thead>
       <tbody>";
  $shippers = $shipperData->result->rows;
  $total = $shipperData->result->count;
  $page = $shipperData->page;
  $pagesize = $shipperData->pagesize;
  $totalpage = ceil($total / $pagesize);
  foreach ($shippers as $item) {
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
</div>";
  echo "<div class='col col-12'>";
  renderPagination($totalpage, $page);
  echo "</div>";
  ?>
</div>
<?php require_once _DIR_ROOT . '/app/views/blocks/scroll-top.php'; ?>
</div>