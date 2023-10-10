<?php include("head.php"); ?>
<!doctype html>
<html lang="fr">

<title>ReSoC - Mur</title>

<body>
    <?php include("header.php"); ?>

    <div id="wrapper">
        < <?php
        $userId = intval($_GET['user_id']);

        if ($userId == null) {
            ?>
                <aside>
                    <section>
                        <h3>Présentation</h3>
                        <p>Sur cette page vous trouverez tous les message de l'utilisatrice :

                        </p>
                    </section>
                </aside>
                <main>
                    <article>
                        <h2>Information</h2>
                        <p>Veuillez vous connecter à votre compte.</p>
                        <p><a href='login.php'>Connectez-vous</a></p><br>
                        <h3>Pas de compte?</h3>
                        <p><a href='registration.php'>Inscrivez-vous</a></p>
                    </article>
                </main>
            <?php } else {
            /**
             * Cette page est TRES similaire à wall.php. 
             * Vous avez sensiblement à y faire la meme chose.
             * Il y a un seul point qui change c'est la requete sql.
             */
            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             */


            /**
             * Etape 2: se connecter à la base de donnée
             */
            include("BDD.php"); ?>

                <aside>
                    <?php
                    /**
                     * Etape 3: récupérer le nom de l'utilisateur
                     */
                    $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                    $lesInformations = $mysqli->query($laQuestionEnSql);
                    $user = $lesInformations->fetch_assoc();
                    //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
                    ?>
                    <?php if ($_SESSION['connected_id'] != "null") {
                        include('photoprofil.php');
                    } ?>
                    <section>
                        <h3>Présentation</h3>
                        <p>Sur cette page vous trouverez tous les message de l'utilisatrice :
                            <?php echo ($user['alias']) ?>
                            (n°
                            <?php echo $userId ?>)
                        </p>
                        <?php include("tests.php") ?>
                    </section>
                </aside>
                <main>
                    <?php include("form.php") ?>
                    <?php
                    /**
                     * Etape 3: récupérer tous les messages de l'utilisatrice
                     */
                    $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name, users.id as author_id, posts.id as postId,
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";

                    $lesInformations = $mysqli->query($laQuestionEnSql);
                    if (!$lesInformations) {
                        echo ("Échec de la requete : " . $mysqli->error);
                    }

                    /**
                     * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                     */
                    include("post.php");
        } ?>


            </main>
    </div>
</body>

</html>