<?php if (!empty($breadcrumbs) && is_array($breadcrumbs)) {
?>

    <style>
        .mm-breadcrumb * {
            color: var(--mm-gray);
            font-size: 1.5rem;
        }
    </style>

    <div class='container bg-white'>
        <div class='mm-breadcrumb py-3'>
            <?php
            $len = sizeof($breadcrumbs);
            foreach ($breadcrumbs as $index => $breadcrumb) {
                $link = $breadcrumb['link'];
                $name = $breadcrumb['name'];

                echo "<a href='$link'>$name</a>";
                if ($index !== $len - 1) {
                    echo "<span>&nbsp;&gt;&nbsp;</span>";
                }
            }
            ?>
        </div>
    </div>
<?php } ?>