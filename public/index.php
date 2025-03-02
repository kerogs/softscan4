<?php

require_once('../config.php');

?>

<!DOCTYPE html>
<html lang="<?= $kpf_config["seo"]["lang_short"] ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once '../inc/head.php' ?>
    <title><?= $kpf_config["seo"]["title_short"] ?></title>
    <link rel="stylesheet" href="src/css/style.css">

    <!-- src -->
    <link rel="stylesheet" href="./node_modules/boxicons/css/boxicons.min.css">
</head>

<body>

    <header>
        <?php require_once '../inc/header.php' ?>

        <div>
            <a href="">
                <img class="logo" src="./src/img/lw.png" alt="">
            </a>
            <form action="" class="search" method="get">
                <div class="inputgroup">
                    <input type="search" name="search" id="">
                    <input type="submit" value="">
                </div>
            </form>
        </div>
    </header>

    <?php require_once '../inc/script.php' ?>
</body>

</html>