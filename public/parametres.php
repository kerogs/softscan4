<?php

require_once('../config.php');

if($_GET['act'] == "parametres") {
    // exec python file in ../backend/scan_and_store.py
    exec("python ../backend/scan_and_store.py");
}

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

    <!-- splide -->
    <link rel="stylesheet" href="./node_modules/@splidejs/splide/dist/css/splide.min.css">
    <script src="./node_modules/@splidejs/splide/dist/js/splide.min.js"></script>
</head>

<body>

    <div class="main-content">
        <?php require_once __DIR__ . '/../inc/aside.php' ?>
        <main>

            <?php require_once __DIR__ . '/../inc/header.php' ?>



            <!-- fin main -->
            <a href="?php2py=scan">Lancer scan</a>
        </main>
    </div>

    <?php require_once '../inc/script.php' ?>
</body>

</html>