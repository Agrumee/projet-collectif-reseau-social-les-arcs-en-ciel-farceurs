<?php include("head.php"); ?>
<!doctype html>
<html lang="fr">
<title>ReSoC - Actualités</title>

<body>
    <?php include("header.php"); ?>
    <div id="wrapper">
        <aside>

            <?php include("BDD.php");
            if ($_SESSION['connected_id'] != null) {
                include('photoprofil.php');
            } else { ?>
                <div class='cropped'>
                    <img src="deco.png" />
                </div>
                <?php
            } ?>
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les derniers messages de
                    tous les utilisatrices du site.</p>
            </section>
        </aside>
        <main>
            <?php
            //Ouvrir une connexion avec la base de donnée.
            if ($mysqli->connect_errno) {
                echo "<article>";
                echo ("Échec de la connexion : " . $mysqli->connect_error);
                echo ("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
                echo "</article>";
                exit();
            }

            // requete sql
            $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name, 
                    users.id as author_id, 
                    posts.id as postId,
                    likes.like_count as like_number,
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN (
                        SELECT post_id, COUNT(DISTINCT id) as like_count
                        FROM likes
                        GROUP BY post_id
                        ) as likes ON likes.post_id = posts.id
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    LIMIT 5
                    ";


            $lesInformations = $mysqli->query($laQuestionEnSql);
            // Vérification
            if (!$lesInformations) {
                echo "<article>";
                echo ("Échec de la requete : " . $mysqli->error);
                echo ("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
                exit();
            }

            // Parcourir ces données et les ranger bien comme il faut dans le post
            include("post.php");
            ?>

        </main>
    </div>
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>