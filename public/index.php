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

    <!-- splide -->
    <link rel="stylesheet" href="./node_modules/@splidejs/splide/dist/css/splide.min.css">
    <script src="./node_modules/@splidejs/splide/dist/js/splide.min.js"></script>
</head>

<body>

    <div class="main-content">

        <img id="mainCoverImageBackground" src="https://placewaifu.com/image/1920/1080" alt="">

        <aside>
            <div class="title">
                <img src="./src/img/lw.png" alt="">
                <h1>SoftScan 4</h1>
            </div>
            <nav>
                <ul>
                    <a href="" class="active">
                        <li class="active"><i data-lucide="home"></i> Accueil</li>
                    </a>
                    <a href="">
                        <li><i data-lucide="gallery-vertical-end"></i> Catégories</li>
                    </a>
                    <a href="">
                        <li><i data-lucide="compass"></i> Découvrir</li>
                    </a>
                    <a href="">
                        <li><i data-lucide="image"></i> Images</li>
                    </a>
                    <a href="">
                        <li><i data-lucide="video"></i> Vidéos</li>
                    </a>
                </ul>
            </nav>
            <div class="info">
                <p class="version">
                    v<?= $kpf_config["other"]["website_version"] ?>
                </p>
            </div>
        </aside>
        <main>

            <?php require_once __DIR__.'/../inc/header.php' ?>

            <div class="splide" id="homeSlider">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide">
                            <div class="content">
                                <img class="mainCoverImage" src="https://placewaifu.com/image/1920/1080" alt="">
                                <div class="filterGradient"></div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="content">
                                <img class="mainCoverImage" src="https://placewaifu.com/image/1420/1080" alt="">
                                <div class="filterGradient"></div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="content">
                                <img class="mainCoverImage" src="https://placewaifu.com/image/1420/1080" alt="">
                                <div class="filterGradient"></div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="content">
                                <img class="mainCoverImage" src="https://placewaifu.com/image/1000/1080" alt="">
                                <div class="filterGradient"></div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="content">
                                <img class="mainCoverImage" src="https://placewaifu.com/image/1420/1030" alt="">
                                <div class="filterGradient"></div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="content">
                                <img class="mainCoverImage" src="https://placewaifu.com/image/1230/1080" alt="">
                                <div class="filterGradient"></div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="content">
                                <img class="mainCoverImage" src="https://placewaifu.com/image/2420/1080" alt="">
                                <div class="filterGradient"></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const splide = new Splide('#homeSlider', {
                        type: 'loop',
                        perPage: 1,
                        autoplay: true,
                        interval: 7000,
                        arrows: true,
                        pagination: true,
                        gap: 10,
                    });

                    const mainCoverImageBackground = document.getElementById('mainCoverImageBackground');

                    // Fonction pour mettre à jour l'image de fond
                    function updateBackgroundImage(newIndex) {
                        const currentSlide = splide.Components.Elements.slides[newIndex]; // Récupère la slide actuelle
                        const mainCoverImage = currentSlide.querySelector('.mainCoverImage'); // Trouve l'image dans la slide
                        if (mainCoverImage) {
                            mainCoverImageBackground.src = mainCoverImage.src; // Change l'image de fond
                        }
                        console.log("mainCoverImageBackground.src : " + mainCoverImageBackground.src);
                    }

                    // Met à jour l'image lors du changement de slide
                    splide.on('moved', function(newIndex) {
                        updateBackgroundImage(newIndex);
                    });

                    splide.mount();

                    // Met à jour l'image dès le chargement
                    updateBackgroundImage(splide.index);
                });
            </script>


            <div class="inn">
                <section>
                    <div class="dernierContenu">
                        <div>
                            <div class="leftTitle">
                                <i data-lucide="undo-dot"></i>
                                <h3>Contenus vu</h3>
                            </div>
                        </div>

                        <div>
                            <div class="leftTitle">
                                <i data-lucide="history"></i>
                                <h3>Catégories vu</h3>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="leftTitle">
                        <i data-lucide="image-plus"></i>
                        <h3>Derniers contenu ajouté</h3>
                    </div>
                </section>
                <section>
                    <div class="leftTitle">
                        <i data-lucide="package-plus"></i>
                        <h3>Dernières catégorie ajouté</h3>
                    </div>
                </section>
                <section>
                    <div class="leftTitle">
                        <i data-lucide="package-plus"></i>
                        <h3>Catégories</h3>
                    </div>
                </section>
            </div>

            <!-- fin main -->
        </main>
    </div>

    <?php require_once '../inc/script.php' ?>
</body>

</html>