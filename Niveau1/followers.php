<?php include("head.php"); ?>
<!doctype html>
<html lang="fr">
<title>ReSoC - Mes abonnés </title>

<body>
    <?php include("header.php"); ?>
    <div id="wrapper">

        <?php if ($_SESSION["connected_id"] == null) {
            ?>
            <aside>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes qui
                        suivent les messages de l'utilisatrice
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
            ?>
            <aside>
                <?php include("BDD.php");
                include('photoprofil.php') ?>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes qui
                        suivent les messages de l'utilisatrice
                        n°
                        <?php echo intval($_GET['user_id']) ?>
                    </p>

                </section>
            </aside>
            <main class='contacts'>
                <?php
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_GET['user_id']);
                // Etape 2: se connecter à la base de donnée
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.*
                    FROM followers
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Etape 4: à vous de jouer
                //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                while ($users = $lesInformations->fetch_assoc()) {
                    ?>

                    <article>
                        <img src="user.jpg" alt="blason" />
                        <h3>
                            <?php echo ($users['alias']) ?>
                        </h3>
                        <p>id:
                            <?php echo ($users['id']) ?>
                        </p>
                    </article>
                <?php } ?>
            </main>
        </div>
    <?php }
        ?>
</body>

</html>