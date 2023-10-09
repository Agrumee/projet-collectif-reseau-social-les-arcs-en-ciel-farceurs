<?php include("head.php"); ?>
<!doctype html>
<html lang="fr">

<title>ReSoC - Mur</title>

<body>
    <?php include("header.php"); ?>

    <div id="wrapper">
        <?php
        /**
         * Cette page est TRES similaire à wall.php. 
         * Vous avez sensiblement à y faire la meme chose.
         * Il y a un seul point qui change c'est la requete sql.
         */
        /**
         * Etape 1: Le mur concerne un utilisateur en particulier
         */
        $userId = intval($_GET['user_id']);
        ?>

        <!-- /**
            * Etape 2: se connecter à la base de donnée
            */ -->
        <?php include("BDD.php"); ?>

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
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les message de l'utilisatrice :
                    <?php echo ($user['alias']) ?>
                    (n°
                    <?php echo $userId ?>)
                </p>
                <?php

                $marequete = "SELECT * FROM followers WHERE followed_user_id='$userId' AND following_user_id='$_SESSION[connected_id]' ";
                $reponse = $mysqli->query($marequete);
                if ($userId != $_SESSION['connected_id'] && mysqli_num_rows($reponse) == 0) { ?>
                    <form action="<?php

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $followed_user_id = $_POST['followed_user_id'];
                        $following_user_id = $_POST['following_user_id'];

                        $lInstructionSql = 'INSERT INTO followers'
                            . '(id, followed_user_id, following_user_id)'
                            . 'VALUES (NULL, '
                            . $followed_user_id . ', '
                            . $following_user_id . ');';
                        $ok = $mysqli->query($lInstructionSql);
                    } ?>" method="post">
                        <input type='hidden' name='followed_user_id' value="<?php echo $userId; ?>">
                        <input type='hidden' name='following_user_id' value="<?php echo $_SESSION['connected_id']; ?>">

                        <input type='submit' value="S'abonner">
                    </form>
                <?php } else if ($userId != $_SESSION['connected_id']) { ?>
                        <form action="<?php
                        if ($_SERVER["REQUEST_METHOD"] === 'POST' && mysqli_num_rows($reponse) > 0) {
                            $followed_user_id = $_POST['followed_user_id'];
                            $following_user_id = $_POST['following_user_id'];

                            $lInstructionSql = 'DELETE FROM followers WHERE
                            followed_user_id=$followed_user_id AND following_user_id =$following_user_id';

                            $ok = $mysqli->prepare($lInstructionSql);
                            $sth->execute();

                            $count = $sth->rowCount();
                        } ?>" method="post">
                            <input type='hidden' name='followed_user_id' value="<?php echo $userId; ?>">
                            <input type='hidden' name='following_user_id' value="<?php echo $_SESSION['connected_id']; ?>">

                            <input type='submit' value="Se désabonner">
                        </form>
                    <?php
                } ?>
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
            ?>

        </main>
    </div>
</body>

</html>