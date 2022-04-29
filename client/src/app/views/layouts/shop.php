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
    <link rel="stylesheet" href="/public/assets/css/shop/header.css">
    <link rel="stylesheet" href="/public/assets/css/shop/navbar.css">

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
    <?php require_once _DIR_ROOT . '/app/views/blocks/shop/header.php'; ?>
    <?php require_once _DIR_ROOT . '/app/views/blocks/shop/navbar.php'; ?>

    <main class="distance-top distance-left" id="main">
        <?php $this->render($viewPath, isset($viewContent) ? $viewContent : []); ?>
        <h1>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Accusamus maiores, nihil dolores architecto, recusandae cum iusto illo sed sunt numquam ea minima quis saepe ut repellat. Accusantium blanditiis quibusdam labore dolorem molestias alias ad suscipit provident! Cupiditate voluptatum quaerat quisquam eligendi voluptatibus, laboriosam animi quam recusandae aut, in architecto ad, hic perspiciatis aliquam id sapiente velit soluta nisi magni exercitationem sint. Facilis veniam in, aliquid quidem, possimus id, ad voluptatibus iusto suscipit recusandae eveniet provident sit itaque ducimus. Suscipit, consectetur fugiat eaque quis illo vero cum sit. Suscipit accusamus repudiandae ullam ducimus corporis dolore rem minima, officia earum aliquam mollitia fugiat labore iusto! Deserunt possimus eius fugiat ipsam officiis saepe omnis ipsum ab totam sapiente temporibus porro modi voluptatibus, minima tempora quibusdam repellendus amet, debitis accusamus aliquam? Repellat perspiciatis, dolore veritatis voluptatibus itaque, fugit accusantium sed illum quis laborum ratione recusandae ducimus a dignissimos accusamus vel dicta quam facilis nobis? Nesciunt delectus dicta temporibus minus qui explicabo, suscipit nemo laboriosam odit itaque placeat voluptatum molestiae quia fuga aliquid! Ipsam iure officia consectetur reiciendis quos consequuntur magnam at laudantium a! Quam nam omnis nobis repudiandae illo ab quisquam quidem aperiam, sequi delectus doloribus expedita dicta iure quasi tempora ipsum sapiente dolorem. Cupiditate, eaque. Cupiditate officia, ipsa optio velit et eum mollitia fugit, repellat minima, impedit illo omnis perspiciatis! Culpa expedita adipisci at voluptatibus, fugiat iste nam ex deleniti error eius facere quidem aliquam quaerat! Aspernatur fuga nisi beatae, quasi voluptatum earum assumenda? Laudantium quia quos perspiciatis cum magni tenetur quo animi sit rerum ullam exercitationem tempora, dolorem a delectus fuga officia repudiandae distinctio accusamus beatae, cumque consectetur dicta eius suscipit quasi? Alias repellat voluptatem delectus quis expedita perspiciatis sed, ratione itaque maxime soluta saepe cum facilis atque quo autem at veritatis quisquam ad quaerat? Voluptatum laboriosam reiciendis doloremque tempore voluptates laborum eius nulla numquam corrupti fugiat quidem, vel, autem rem aliquid distinctio? Accusantium sequi nesciunt quidem tenetur voluptates necessitatibus consectetur cupiditate! Culpa quod, voluptates quidem voluptate at id itaque eos ratione obcaecati, nesciunt, totam quos nam ipsam autem temporibus dolorem consequatur minus sed recusandae dolorum quo. Provident saepe culpa omnis veritatis molestiae. Numquam deleniti, doloribus, id deserunt modi provident tenetur nesciunt fuga exercitationem qui animi sapiente? Consectetur adipisci accusantium et aperiam ipsa necessitatibus vitae deleniti recusandae pariatur veniam quas tempore at tenetur expedita eveniet laborum provident, perferendis cumque totam repudiandae? Quos voluptas vero aperiam, id facere consequatur sint aut officia ratione consectetur, corrupti voluptatibus. Possimus error adipisci laborum at officia autem, qui aperiam iusto ut similique odio, minus aspernatur sit sapiente quidem veniam omnis consectetur placeat necessitatibus! Saepe nulla accusamus minima, dignissimos beatae molestiae neque molestias modi qui consectetur maiores maxime perspiciatis vitae fugiat cumque nihil, provident culpa vel? Deleniti laudantium eius labore perferendis voluptates doloremque cum veniam. Sint architecto veniam recusandae nam ipsum beatae alias nesciunt aliquid velit. Quasi sed maiores sunt perferendis pariatur! Sint, ut animi tenetur veniam est doloribus architecto odio iure nesciunt beatae quos unde suscipit molestiae asperiores incidunt mollitia quam dolores. Debitis iusto quia iste ipsa atque modi ipsum delectus, nulla a qui exercitationem facilis quas unde et, aperiam animi nesciunt hic nisi eos sit. Maxime natus optio obcaecati quis autem deleniti fugiat assumenda quas nulla. Natus vitae voluptatem odit dolorum quam vero explicabo ab repudiandae placeat aspernatur? Atque possimus ipsa soluta, magni consectetur perferendis est in praesentium numquam temporibus. Quia saepe eligendi, consectetur repellat atque eos omnis odit, laudantium et fuga laborum libero minus! Tenetur dicta, voluptas laudantium accusamus distinctio dolorum quo rerum ex omnis eligendi exercitationem nesciunt adipisci magnam eveniet. Natus, reiciendis quam itaque sint ipsum rerum adipisci nesciunt! Vel dignissimos enim nulla sit, veniam adipisci. Molestiae eligendi quae dolorum aliquid, veritatis ratione delectus eos sint hic sapiente nobis inventore tenetur laborum dignissimos dolorem ad ex temporibus a porro! Asperiores odit corporis, magni eligendi inventore tenetur ducimus ipsum dolorem debitis quasi, nihil consequatur dolore expedita perspiciatis incidunt animi quis, officia eaque dolores suscipit mollitia voluptatem illum distinctio ea. Tempore quaerat ad maiores repellendus veniam repudiandae laboriosam autem deleniti quas in esse quo laborum atque dolor ipsam, perspiciatis fuga quod quia voluptate optio maxime reiciendis dicta voluptatem accusamus? Deleniti debitis et voluptatem possimus voluptatum, sapiente officiis eveniet sint distinctio quaerat, sit tempora provident impedit, saepe architecto facilis. Voluptas aperiam asperiores laudantium ab sint? Aliquam quo fugiat doloribus autem quis asperiores enim! Voluptatum nulla ullam ut, laudantium nostrum quas voluptatibus! Atque, iure adipisci blanditiis quas velit explicabo sunt vel pariatur nostrum minus hic ducimus odio. Quaerat, accusantium? Sit laudantium placeat illum, minus corporis fugit totam accusantium nisi aspernatur in ex distinctio vel iusto molestiae eaque voluptatum dolores nobis? Praesentium tempore voluptatum veniam, at odio corporis, voluptas ratione eius dignissimos autem aspernatur iusto ipsum magni unde aliquid modi aut provident hic repudiandae consequuntur sapiente architecto quo eum. Exercitationem voluptates eos doloremque est, tempora odio, nulla provident dolorem totam eveniet at quas incidunt praesentium. Accusantium, impedit. Maxime nisi deserunt est amet recusandae neque quae quasi delectus doloremque inventore iste, quod, fuga, ad cupiditate? Rerum mollitia nulla libero, quasi aliquid expedita optio nam sequi consequatur fugit sunt quam quos iusto ullam illo? Veniam eum quibusdam molestiae sequi est dolores quod, quo optio vitae ad hic, culpa consequuntur animi consectetur sunt repellat qui aperiam laboriosam enim quos! Quisquam itaque aliquid soluta dicta hic voluptatem nisi, iure officiis consequuntur quibusdam voluptatibus dignissimos, maiores, corporis accusamus placeat perferendis ab sit dolore nostrum id? Possimus rerum beatae repellendus quisquam mollitia debitis voluptatibus tempora animi natus, libero vitae expedita facere hic vero, velit ea accusamus obcaecati? Possimus cumque vero vel veritatis, repellendus reprehenderit. Repellendus sint iure quod totam deserunt obcaecati maiores delectus pariatur accusantium sapiente in nulla voluptate ipsa corrupti libero dignissimos quam, consequuntur voluptatum aspernatur tenetur beatae architecto debitis iusto. Quos dolores dolorem non, illo ad quis enim, expedita iusto, quia tenetur ut quibusdam ratione recusandae iste. At porro odit explicabo, repellendus unde quam, quibusdam voluptatum possimus officia cumque impedit ea sequi sit earum. Nulla deleniti eligendi soluta perspiciatis enim facilis nesciunt officia totam? Vero ratione sit perspiciatis. Ducimus necessitatibus explicabo quidem itaque ut rerum impedit, enim recusandae earum? Eligendi sunt provident, beatae ipsum nisi neque omnis voluptas ducimus minus illum quo natus! Repellendus expedita nemo quaerat sed, laborum quis sapiente ab, assumenda iste, rerum at ducimus modi molestiae eveniet quisquam! Unde sunt expedita eveniet voluptatem optio inventore aut, quis voluptas, quae cupiditate error sequi odio, quidem obcaecati nam ipsa assumenda at consectetur. Corporis omnis fugit excepturi distinctio neque laborum, earum vitae. Asperiores ut explicabo a rerum. Incidunt explicabo non exercitationem quis ipsum quas, iure illum odio? Quidem, voluptatum? Corporis eaque aperiam quas dignissimos quo nisi enim quaerat dolores numquam et qui quos culpa eos earum minima, corrupti, molestias facere. Incidunt harum labore minima, est consequatur ratione libero ea veritatis odit distinctio non magni adipisci dolorum porro corrupti officia hic similique ut eaque? Voluptate nostrum veniam magni numquam sed. Ducimus est impedit doloremque, nisi eveniet quis iusto illum ullam, quasi odit nostrum labore omnis asperiores animi quaerat nam. Odit, beatae nihil? Ipsam non, omnis alias nemo suscipit laborum ex sequi nisi necessitatibus odit corrupti aperiam quam officiis commodi reiciendis illo optio provident. Culpa placeat minus fuga dolorem facere consectetur dolorum qui quam repellat itaque. Repellat obcaecati nam quia facilis distinctio, vitae deleniti, id repudiandae ratione modi molestias temporibus. Consequuntur sed iure quidem libero expedita, id obcaecati animi ut nihil molestiae, modi quae, vel eligendi non molestias quod cupiditate aspernatur ipsam cumque ad suscipit dolorum! Iure repellat ducimus sed labore iusto neque? Velit iste aspernatur neque alias consequuntur blanditiis esse modi at dolore fugit iure quidem est molestiae, natus pariatur aut sunt, maiores magni obcaecati eaque? Labore, amet in sint dignissimos iure cumque quisquam! Eligendi, minus? Delectus asperiores quae itaque laboriosam, accusantium, veritatis ab maxime error atque sint id! Necessitatibus accusantium laborum, obcaecati tenetur omnis voluptatibus recusandae incidunt. Soluta inventore mollitia quibusdam vero in consequatur. Temporibus nobis nihil facilis itaque magni necessitatibus, soluta dignissimos quaerat atque sed aliquam quae alias, quas id at. Dolores, laborum totam. Reiciendis, animi error. Dolore vel similique facere numquam qui quam fugit nemo minus debitis placeat, blanditiis ex nobis quo amet odio quos sed illo? Temporibus magnam praesentium beatae doloremque eveniet delectus, ipsa ad atque quis sed rerum ipsum facilis velit at? Ipsum quae fugiat eveniet eligendi qui quis illum sapiente. Obcaecati cum enim deleniti placeat maxime perspiciatis nesciunt, quisquam dolorem soluta ex at iusto. Eum ut sed quidem consectetur. Molestias, quaerat tenetur. Earum repellat, fuga quidem porro, voluptatem adipisci soluta quisquam aliquid, accusamus eaque pariatur. Rerum accusantium explicabo consequuntur cupiditate inventore, enim quia unde iusto aliquid nobis esse illum non facere ullam sit in soluta dolorem dicta quam. Tempore ut minus quasi debitis? Nihil, asperiores. Itaque enim, earum molestiae deleniti sequi inventore iste cupiditate ducimus minus debitis asperiores, illum accusamus quia, odio nemo corporis nam laborum mollitia ea reiciendis id est nulla? Voluptates libero maxime eligendi adipisci beatae vel consectetur cumque! Aut voluptatem quasi rem doloribus blanditiis est officiis nemo assumenda dolorem voluptatibus sunt, explicabo earum, quos libero provident beatae quae sequi dolore, temporibus autem corrupti quidem aliquam!</h1>
    </main>

</body>

<script src="/public/vendors/jquery/jquery.min.js"></script>
<?php require_once _DIR_ROOT . '/app/views/blocks/cdn/popper.php' ?>
<script src="/public/vendors/bootstrap/bootstrap.min.js"></script>
<script src='/public/assets/js/shop/navbar.js'></script>

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

// Add JS link
if (!empty($jsLinks)) {
    foreach ($jsLinks as $filename) {
        echo "<script src='/public/assets/js/$filename'></script>";
    }
}
?>

</html>