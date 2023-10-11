<?php include("head.php"); ?>
<!doctype html>
<html lang="fr">
<title>ReSoC - Mes abonnements</title>

<body>
    <?php include("header.php"); ?>
    <div id="wrapper">
        <?php if ($_SESSION["connected_id"] == null) {
            ?>

            <aside>
                <div class='cropped'>
                    <img src="deco.png"/>
                </div>
                <section>
                    <h3>Présentation</h2>
                        <p>Sur cette page vous trouverez la liste des personnes dont
                            l'utilisatrice
                            suit les messages.</p>
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
        <aside>
            <?php include("BDD.php");
            if ($_SESSION['connected_id'] != "null") {
                include('photoprofil.php');
            } ?>
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez la liste des personnes dont
                    l'utilisatrice
                    n°
                    <?php echo intval($_GET['user_id']) ?>
                    suit les messages
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
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            // Etape 4: à vous de jouer
            //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
            while ($users = $lesInformations->fetch_assoc()) {
                ?>
                <article>
                    <div id="followers">
                        <div id="blason">
                            <img src="<?php if ($users['photo'] != "0") {
                                echo ($users['photo']);
                            } else {
                                echo "user.jpg";
                            } ?>" alt="blason" />
                        </div>
                        <h3>
                            <?php echo ($users['alias']) ?>
                        </h3>
                        <p style="display:none">id:
                            <?php echo ($users['id']) ?>
                        </p>
                    </div>
                </article>
            <?php } ?>
        </main>
        </div>
    <?php }
        ?>
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>