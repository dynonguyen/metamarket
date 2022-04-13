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

    <link rel="icon" type="image/x-icon" href="/public/assets/images/favicon.png">
    <link rel="stylesheet" href="/public/vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/css/utils/common.css">
    <link rel="stylesheet" href="/public/assets/css/utils/atomic.css">
    <link rel="stylesheet" href="/public/assets/css/utils/bootstrap-custom.css">
    <link rel="stylesheet" href="/public/assets/css/header.css">
    <link rel="stylesheet" href="/public/assets/css/footer.css">

    <?php
    // Bootstrap icon
    require_once _DIR_ROOT . '/app/views/blocks/cdn/bootstrap-icon.php';
    ?>

    <?php
    // Add css link
    if (!empty($cssLinks)) {
        foreach ($cssLinks as $filename) {
            echo "<link rel='stylesheet' href='/public/assets/css/$filename'>";
        }
    }
    ?>

</head>

<body>
    <?php $this->render('blocks/header'); ?>

    <?php $this->render($viewPath, isset($viewContent) ? $viewContent : []); ?>

    <?php require_once _DIR_ROOT . '/app/views/blocks/footer.php' ?>
</body>

<script src="/public/vendors/bootstrap/bootstrap.min.js"></script>
<script src="/public/vendors/jquery/jquery.min.js"></script>

<!-- Add JS link -->
<?php
if (!empty($jsLinks)) {
    foreach ($jsLinks as $filename) {
        echo "<script src='/public/assets/js/$filename'></script>";
    }
}
?>

</html>