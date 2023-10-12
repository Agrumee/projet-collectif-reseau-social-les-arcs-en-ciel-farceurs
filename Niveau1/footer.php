<nav id="menu">
    <div><a href="news.php">Actualités</a> </div>
    <div><a href="wall.php?user_id=<?php echo $_SESSION['connected_id']?>">Mur</a></div>
    <div><a href="feed.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Flux</a></div>
    <div><a href="tags.php?tag_id=1">Mots-clés</a></div>
</nav>