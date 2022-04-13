<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo !empty($pageTitle) ? $pageTitle : "Trang Chủ" ?>
    </title>

    <link rel="icon" type="image/x-icon" href="/public/assets/clients/images/favicon.png">
    <link rel="stylesheet" href="/public/vendors/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/clients/css/style.css">
</head>

<body>
    <?php $this->render('blocks/header'); ?>

    <?php $this->render($viewPath, isset($viewContent) ? $viewContent : []); ?>

    <?php require_once _DIR_ROOT . '/app/views/blocks/footer.php' ?>
</body>

<script src="/public/vendors/bootstrap/bootstrap.min.js"></script>
<script src="/public/vendors/jquery/jquery.min.js"></script>

</html>