<?php
/* 
    **
    pageTitle: string
    cssLinks: array[css file name]
    jsLinks: array[js file name]
    isBootstrapIcon: boolean
    viewPath: string [rendered file]
    viewContent: array [data for viewPath file]
    **
*/
$staticUrl = STATIC_FILE_URL;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo !empty($pageTitle) ? $pageTitle : "Trang Chủ" ?>
    </title>

    <?php
    echo "<link rel='icon' type='image/x-icon' href='$staticUrl/assets/images/favicon.png'>";
    echo "<link rel='stylesheet' href='$staticUrl/vendors/bootstrap/bootstrap.min.css'>";
    echo "<link rel='stylesheet' href='$staticUrl/assets/css/utils/common.css'>";
    echo "<link rel='stylesheet' href='$staticUrl/assets/css/utils/atomic.css'>";
    echo "<link rel='stylesheet' href='$staticUrl/assets/css/utils/bootstrap-custom.css'>";
    echo "<link rel='stylesheet' href='$staticUrl/assets/css/shop/header.css'>";
    echo "<link rel='stylesheet' href='$staticUrl/assets/css/shop/navbar.css'>";
    ?>

    <?php
    // Bootstrap icon
    require_once _DIR_ROOT . '/app/views/blocks/cdn/bootstrap-icon.php';
    ?>

    <?php
    if (!empty($cssCDN)) {
        foreach ($cssCDN as $cdn) {
            echo "<link rel='stylesheet' href='$cdn'>";
        }
    }
    // Add css link
    if (!empty($cssLinks)) {
        foreach ($cssLinks as $filename) {
            echo "<link rel='stylesheet' href='$staticUrl/assets/css/$filename'>";
        }
    }
    ?>

</head>

<body>
    <?php require_once _DIR_ROOT . '/app/views/blocks/shipper/header.php'; ?>
    <?php require_once _DIR_ROOT . '/app/views/blocks/shipper/navbar.php'; ?>

    <main class="distance-top distance-left" id="main">
        <?php $this->render($viewPath, isset($viewContent) ? $viewContent : []); ?>
    </main>

</body>

<?php
echo "<script src='$staticUrl/vendors/jquery/jquery.min.js'></script>";
require_once _DIR_ROOT . '/app/views/blocks/cdn/popper.php';
echo "<script src='$staticUrl/vendors/bootstrap/bootstrap.min.js'></script>";
echo "<script src='$staticUrl/assets/js/shop/navbar.js'></script>";
?>

<?php
// passed variable
if (!empty($passedVariables)) {
    echo "<script>";
    foreach ($passedVariables as $key => $value) {
        echo "const $key = '$value';";
    }
    echo "</script>";
}
?>

<?php
// Add JS CDN
if (!empty($jsCDN)) {
    foreach ($jsCDN as $cdn) {
        echo "<script src='$cdn'></script>";
    }
}
// Add JS link
if (!empty($jsLinks)) {
    foreach ($jsLinks as $filename) {
        echo "<script src='$staticUrl/assets/js/$filename'></script>";
    }
}
?>

</html>