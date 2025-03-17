<aside>
    <div class="title">
        <img src="./src/img/lw.png" alt="">
        <h1>SoftScan 4</h1>
    </div>
    <nav>
        <ul>
            <a href="/" class="<?= $filename == "index.php" ? "active" : "" ?>">
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
            <hr>
            <a href="/parametres" class="<?= $filename == "parametres.php" ? "active" : "" ?>">
                <li><i data-lucide="settings"></i> Paramètres</li>
            </a>
        </ul>
    </nav>
    <div class="info">
        <p class="version">
            v<?= $kpf_config["other"]["website_version"] ?>
        </p>
    </div>
</aside>