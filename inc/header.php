<header>
    <?php require_once '../inc/header.php' ?>

    <div>
        <form action="" class="search" method="get">
            <div class="inputgroup">
                <button type="submit">
                    <i data-lucide="search"></i>
                </button>
                <input type="search" name="s" placeholder="Search" value="<?= $_GET['s'] ?>" id="">
            </div>
        </form>
    </div>
    <!-- fin header -->
</header>