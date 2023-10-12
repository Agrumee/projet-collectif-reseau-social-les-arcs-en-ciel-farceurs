<?php include("head.php"); ?>
<!doctype html>
<html lang="fr">
<title>ReSoC - Administration</title>

<body>
    <?php include("header.php"); ?>

    <!--Ouvrir une connexion avec la base de données -->

    <?php include("BDD.php");

    if ($mysqli->connect_errno) {
        echo ("Échec de la connexion : " . $mysqli->connect_error);
        exit();
    }
    ?>
    <div id="wrapper" class='admin'>
        <aside>
            <h2>Mots-clés</h2>
            <?php
            /*
             * trouver tous les mots clés
             */
            $laQuestionEnSql = "SELECT * FROM `tags` LIMIT 50";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            // Vérification
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
                exit();
            }

            /*
             * Afficher les mots clés en s'inspirant de ce qui a été fait dans news.php
             */
            while ($tag = $lesInformations->fetch_assoc()) {
                ?>
                <article>
                    <h3>
                        <?php echo ("#" . $tag['label']) ?>
                    </h3>
                    <p>
                        <?php echo ("id: " . $tag['id']) ?>
                    </p>
                    <nav>
                        <a href='tags.php?tag_id=<?php echo ($tag['id']) ?>'>Messages</a>
                    </nav>
                </article>
            <?php } ?>
        </aside>
        <main>
            <h2>Utilisatrices</h2>
            <?php
            /*
             * trouver tous les mots clés
             */
            $laQuestionEnSql = "SELECT * FROM `users` LIMIT 50";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            // Vérification
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
                exit();
            }

            /*
             * Afficher les utilisatrices en s'inspirant de ce qui a été fait dans news.php
             */
            while ($users = $lesInformations->fetch_assoc()) {
                echo "<pre>" . print_r($tag, 1) . "</pre>";
                ?>
                <article>
                    <h3>
                        <?php echo ($users['alias']) ?>
                    </h3>
                    <p>
                        <?php echo ("id: " . $users['id']) ?>
                    </p>

                    <nav>
                        <a href="wall.php?user_id=<?php echo ($users['id']) ?>">Mur</a>
                        | <a href="feed.php?user_id=<?php echo ($users['id']) ?>">Flux</a>
                        | <a href="settings.php?user_id=<?php echo ($users['id']) ?>">Paramètres</a>
                        | <a href="followers.php?user_id=<?php echo ($users['id']) ?>">Suiveurs</a>
                        | <a href="subscriptions.php?user_id=<?php echo ($users['id']) ?>">Abonnements</a>
                    </nav>
                </article>
            <?php } ?>
        </main>
    </div>
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>