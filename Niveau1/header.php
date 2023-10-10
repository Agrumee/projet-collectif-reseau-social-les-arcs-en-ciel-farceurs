<header>
    <img src="resoc.png" alt="Logo de notre réseau social" />
    <nav id="menu">
        <a href="news.php">Actualités</a>
        <a href="wall.php?user_id=<?php echo $userId ?>">Mur</a>
        <a href="feed.php?user_id=<?php echo $userId ?>">Flux</a>
        <a href="tags.php?tag_id=1">Mots-clés</a>
    </nav>
    <nav id="user">
        <a href="<?php if ($_SESSION['connected_id'] === null) {
            echo "login.php";
        } ?>">Profil</a>
        <ul>
            <li><a href="settings.php?user_id=<?php echo $userId ?>">Paramètres</a></li>
            <li><a href="followers.php?user_id=<?php echo $userId ?>">Mes suiveurs</a></li>
            <li><a href="subscriptions.php?user_id=<?php echo $userId ?>">Mes abonnements</a></li>
            <li><a href="login.php">Connexion</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>