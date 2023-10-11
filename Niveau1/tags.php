<?php include("head.php"); ?>
<!doctype html>
<html lang="fr">
<title>ReSoC - Les message par mot-clé</title>

<body>
    <?php include("header.php"); ?>

    <div id="wrapper">
        <?php
        /**
         * Cette page est similaire à wall.php ou feed.php 
         * mais elle porte sur les mots-clés (tags)
         */
        /**
         * Etape 1: Le mur concerne un mot-clé en particulier
         */
        $tagId = intval($_GET['tag_id']);
        ?>
        <!-- /**
             * Etape 2: se connecter à la base de donnée
             */ -->
        <?php include("BDD.php"); ?>


        <aside>
            <?php
            /**
             * Etape 3: récupérer le nom du mot-clé
             */
            $laQuestionEnSql = "SELECT * FROM tags WHERE id= '$tagId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $tag = $lesInformations->fetch_assoc();
            //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par le label et effacer la ligne ci-dessous
            if ($_SESSION['connected_id'] != null) {
                include('photoprofil.php');
            } else {
                echo "<div class='cropped'></div>";
            } ?>

            <section>

                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les derniers messages comportant
                    le mot-clé
                    <?php echo $tag["label"] ?>
                </p>

            </section>
        </aside>
        <main>
            <?php
            /**
             * Etape 3: récupérer tous les messages avec un mot clé donné
             */
            $laQuestionEnSql = "
            SELECT posts.content,
            posts.created,
            users.alias as author_name,
            users.id as author_id,
            posts.id as postId,
            likes.like_number,
            tags.taglist
            FROM posts_tags as filter
            JOIN posts ON posts.id = filter.post_id
            JOIN users ON users.id = posts.user_id
            LEFT JOIN (
                SELECT post_id, COUNT(DISTINCT id) as like_number
                FROM likes
                GROUP BY post_id
            ) as likes ON likes.post_id = posts.id
            LEFT JOIN (
                SELECT post_id, GROUP_CONCAT(DISTINCT tags.label) AS taglist
                FROM posts_tags
                LEFT JOIN tags ON posts_tags.tag_id = tags.id
                GROUP BY post_id
            ) as tags ON tags.post_id = posts.id
            WHERE filter.tag_id = '$tagId'
            GROUP BY posts.id
            ORDER BY posts.created DESC;
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
            }

            /**
             * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
             */
            include("post.php");
            ?>
        </main>
    </div>
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>