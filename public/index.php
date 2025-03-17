<?php

require_once('../config.php');

// Connexion à la base de données tree.db
$dbTree = new SQLite3(__DIR__ . '/../backend/db/tree.db');

// Récupérer 5 images aléatoires
$query = $dbTree->query("
    SELECT * FROM files 
    WHERE classification = 'image' 
    ORDER BY RANDOM() 
    LIMIT 5
");

$slides = [];
while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
    $slides[] = $row;
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

        <img id="mainCoverImageBackground" src="https://placewaifu.com/image/1920/1080" alt="">
        <?php require_once __DIR__ . '/../inc/aside.php' ?>
        <main>

            <?php require_once __DIR__ . '/../inc/header.php' ?>

            <div class="splide" id="homeSlider">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach ($slides as $slide) : ?>
                            <?php
                            // Récupérer les sous-dossiers (catégories)
                            $folderPath = $slide['folder_path'];
                            $categories = array_filter(explode('\\', $folderPath)); // Séparer le chemin en sous-dossiers
                            $categories = array_slice($categories, -5); // Limiter à 5 sous-dossiers
                            ?>
                            <li class="splide__slide">
                                <div class="content">
                                    <div class="topleft">
                                        <div class="stats">
                                            <a href="/gif"><span><i data-lucide="image-play"></i> <?= ucfirst($slide['classification']) ?></span></a>
                                            <span><i data-lucide="eye"></i> <?= $slide['views'] ?></span>
                                            <span><i data-lucide="heart"></i> <?= $slide['likes'] ?></span>
                                        </div>
                                    </div>
                                    <div class="bottomleft">
                                        <div class="buttons">
                                            <a href="view?id=<?= $slide['id'] ?>">
                                                <button class="primary"><i data-lucide="book-open-text"></i> Voir</button>
                                            </a>
                                            <a href="public_data/<?= $slide['full_path'] ?>" target="_blank">
                                                <button><i data-lucide="square-arrow-out-up-right"></i> Ouvrir seul</button>
                                            </a>
                                            <a href="public_data/<?= $slide['full_path'] ?>" target="_blank" download>
                                                <button><i data-lucide="download"></i> Télécharger</button>
                                            </a>
                                            <!-- <a href="">
                                                <button><i data-lucide="link-2"></i> URL</button>
                                            </a> -->
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="category">
                                            <?php
                                            // Récupérer les sous-dossiers (catégories)
                                            $folderPath = $slide['folder_path'];
                                            $categories = array_filter(explode('\\', $folderPath)); // Séparer le chemin en sous-dossiers
                                            $categories = array_slice($categories, -5); // Limiter à 5 sous-dossiers

                                            // Chemin de base pour les catégories
                                            $basePath = "public_data/";

                                            // Parcourir chaque catégorie
                                            foreach ($categories as $index => $category) :
                                                // Construire le chemin complet de la catégorie
                                                $fullCategoryPath = $basePath . implode('\\', array_slice($categories, 0, $index + 1));

                                                // Récupérer une image aléatoire dans la catégorie
                                                $categoryImages = array_merge(
                                                    glob("$fullCategoryPath/*.jpg"),
                                                    glob("$fullCategoryPath/*.png"),
                                                    glob("$fullCategoryPath/*.webp")
                                                );
                                                $categoryImage = !empty($categoryImages) ? $categoryImages[array_rand($categoryImages)] : 'src/img/default/placehold.jpg';
                                            ?>
                                                <a href="/category?path=<?= $fullCategoryPath ?>">
                                                    <div class="category__item">
                                                        <img src="<?= $categoryImage ?>" alt="">
                                                        <div class="info">
                                                            <p class="name"><?= $category ?></p>
                                                            <!-- <p class="numberContents"><?= $fullCategoryPath ?></p> -->
                                                            <p>Catégorie</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <img class="mainCoverImage" src="public_data/<?= $slide['full_path'] ?>" alt="">
                                    <div class="filterGradient"></div>
                                </div>
                            </li>
                        <?php endforeach; ?>
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
                <section>
                    <div class="leftTitle">
                        <i data-lucide="image-plus"></i>
                        <h3>Derniers contenu ajouté</h3>
                    </div>
                </section>
                <!-- Catégories -->
                <section class="category">
                    <div class="leftTitle">
                        <i data-lucide="package"></i>
                        <h3>Catégories</h3>
                    </div>
                    <div class="categorybox">
                        <a href="">
                            <div class="categorybox__item">
                                <img src="https://placeholderimage.eu/api/<?= rand(800, 1200) ?>/<?= rand(400, 600) ?>" alt="">
                            </div>
                        </a>
                    </div>
                </section>
            </div>

            <!-- fin main -->
        </main>
    </div>

    <?php require_once '../inc/script.php' ?>
</body>

</html>