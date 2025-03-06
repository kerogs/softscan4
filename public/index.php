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
        <?php require_once __DIR__ . '/../inc/aside.php' ?>
        <main>

            <?php require_once __DIR__ . '/../inc/header.php' ?>

            <div class="splide" id="homeSlider">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php for ($i = 0; $i < 5; $i++) : ?>
                            <li class="splide__slide">
                                <div class="content">
                                    <div class="topleft">
                                        <div class="stats">
                                            <a href="/gif"><span><i data-lucide="image-play"></i> GIF</span></a>
                                            <span><i data-lucide="eye"></i> 1232</span>
                                            <span><i data-lucide="heart"></i> 58</span>
                                        </div>
                                    </div>
                                    <div class="bottomleft">
                                        <div class="buttons">
                                            <a href="">
                                                <button class="primary"><i data-lucide="book-open-text"></i> Voir</button>
                                            </a>
                                            <a href="">
                                                <button><i data-lucide="square-arrow-out-up-right"></i> Ouvrir seul</button>
                                            </a>
                                            <a href="">
                                                <button><i data-lucide="download"></i> Telecharger</button>
                                            </a>
                                            <a href="">
                                                <button><i data-lucide="link-2"></i> URL</button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="category">
                                            <a href="">
                                                <div class="category__item">
                                                    <img src="https://placeholderimage.eu/api/50/50" alt="">
                                                    <div class="info">
                                                        <p class="name">TitreCollections</p>
                                                        <p class="numberContents">123 Contenus</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="">
                                                <div class="category__item">
                                                    <img src="https://placeholderimage.eu/api/50/50" alt="">
                                                    <div class="info">
                                                        <p class="name">TitreCollections</p>
                                                        <p class="numberContents">123 Contenus</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="">
                                                <div class="category__item">
                                                    <img src="https://placewaifu.com/image/50/50" alt="">
                                                    <div class="info">
                                                        <p class="name">TitreCollections</p>
                                                        <p class="numberContents">123 Contenus</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="">
                                                <div class="category__item">
                                                    <img src="https://placewaifu.com/image/50/50" alt="">
                                                    <div class="info">
                                                        <p class="name">TitreCollections</p>
                                                        <p class="numberContents">123 Contenus</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <img class="mainCoverImage" src="https://placeholderimage.eu/api/<?= rand(800, 1200) ?>/<?= rand(400, 600) ?>" alt="">
                                    <div class="filterGradient"></div>
                                </div>
                            </li>
                        <?php endfor; ?>
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
                        <i data-lucide="shuffle"></i>
                        <h3>Proposition d'image</h3>
                    </div>
                </section>
                <section>
                    <div class="leftTitle">
                        <i data-lucide="package-plus"></i>
                        <h3>Dernières catégorie ajouté</h3>
                    </div>
                </section>
                <section class="category">
                    <div class="leftTitle">
                        <i data-lucide="image-plus"></i>
                        <h3>Derniers contenu ajouté</h3>
                    </div>
                    <div class="categorybox">
                        <a href="">
                            <div class="categorybox__item">
                                <img src="https://placeholderimage.eu/api/<?=  rand(800, 1200) ?>/<?= rand(400, 600) ?>" alt="">

                            </div>
                        </a>
                    </div>
                </section>
                <section>
                    <div class="leftTitle">
                        <i data-lucide="package"></i>
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