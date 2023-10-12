<?php include("head.php"); ?>
<!doctype html>
<html lang="fr">
<title>ReSoC - Flux</title>

<body>
    <?php include("header.php"); ?>
    <div id="wrapper">

        <?php if ($_SESSION["connected_id"] == null) {
            ?>
            <aside>
                <?php
                error_reporting(E_ALL);
                ini_set("display_errors", 1);
                ?>
                <div class='cropped'>
                    <img src="deco.png" />
                </div>
                <section>
                    <h3>Présentation</h3>
                    <p>
                        Sur cette page vous trouverez tous les message des utilisatrices
                        auxquel est abonnée l'utilisatrice. </p>
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
        </div>
    <?php } else {
            ?>

        <!-- Le mur concerne un utilisateur en particulier -->
        <?php $userId = intval($_GET['user_id']); ?>

        <!-- se connecter à la base de donnée -->
        <?php include("BDD.php"); ?>

        <aside>
            <?php
            /**
             * récupérer le nom de l'utilisateur
             */
            $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();
            ?>
            <?php
            include('photoprofil.php');
            ?>
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les message des utilisatrices
                    auxquel est abonnée l'utilisatrice :
                    <?php echo ("n° " . $userId); ?>
                </p>
            </section>
        </aside>
        <main>
            <?php
            /**
             * récupérer tous les messages des abonnements
             */
            $laQuestionEnSql = "
                SELECT posts.content,
                posts.created,
                users.alias as author_name,
                users.id as author_id,
                likes.like_count as like_number,
                posts.id as postId,
                GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                FROM followers 
                JOIN users ON users.id=followers.followed_user_id
                JOIN posts ON posts.user_id=users.id
                LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                LEFT JOIN tags ON posts_tags.tag_id = tags.id 
                LEFT JOIN (
                SELECT post_id, COUNT(DISTINCT id) as like_count
                FROM likes
                GROUP BY post_id
                ) as likes ON likes.post_id = posts.id
                WHERE followers.following_user_id='$userId' 
                GROUP BY posts.id
                ORDER BY posts.created DESC;
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
            }

            /**
             *  Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
             */
            include("post.php");
            ?>
        </main>

    <?php }
        ?>
    </div>
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>



</html>