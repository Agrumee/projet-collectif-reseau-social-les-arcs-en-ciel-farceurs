<?php include("head.php"); ?>
<!doctype html>
<html lang="fr">
<title>ReSoC - Connexion</title>

<body>
    <?php include("header.php"); ?>

    <div id="wrapper">

        <aside>
            <div class='cropped'>
                <img src="deco.png" />
            </div>
            <section>
                <h3>Présentation</h2>
                    <p>Bienvenu sur notre réseau social.</p>
            </section>
        </aside>
        <main>
            <article>
                <h2>Connexion</h2>
                <?php
                /**
                 * TRAITEMENT DU FORMULAIRE
                 */
                // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
                // si on recoit un champs email rempli il y a une chance que ce soit un traitement
                $enCoursDeTraitement = isset($_POST['email']);
                if ($enCoursDeTraitement) {
                    // Etape 2: récupérer ce qu'il y a dans le formulaire 
                    $emailAVerifier = $_POST['email'];
                    $passwdAVerifier = $_POST['motpasse'];


                    // Etape 3 : Ouvrir une connexion avec la base de donnée.
                    include("BDD.php");
                    // Etape 4 : Petite sécurité
                    // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                    $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
                    $passwdAVerifier = $mysqli->real_escape_string($passwdAVerifier);
                    // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                    $passwdAVerifier = md5($passwdAVerifier);
                    // Etape 5 : construction de la requete
                    $lInstructionSql = "SELECT * "
                        . "FROM users "
                        . "WHERE "
                        . "email LIKE '" . $emailAVerifier . "'"
                    ;
                    // Etape 6: Vérification de l'utilisateur
                    $res = $mysqli->query($lInstructionSql);
                    $user = $res->fetch_assoc();
                    if (!$user or $user["password"] != $passwdAVerifier) {
                        echo "La connexion a échouée. ";
                    } else {
                        echo "Votre connexion est un succès : " . $user['alias'] . ".";
                        // Etape 7 : Se souvenir que l'utilisateur s'est connecté pour la suite en utilisant la globale SESSION
                        $_SESSION['connected_id'] = $user['id'];
                    }
                }
                ?>
                <form action="login.php" method="post">
                    <input type='hidden' name='???' value='achanger'>
                    <dl>
                        <dt><label for='email'>E-Mail</label></dt>
                        <dd><input type='email' name='email'></dd>
                        <dt><label for='motpasse'>Mot de passe</label></dt>
                        <dd><input type='password' name='motpasse'></dd>
                    </dl>
                    <input type='submit'>
                </form>
                <p>
                    Pas de compte?
                    <a href='registration.php'>Inscrivez-vous.</a>
                </p>

            </article>
        </main>
    </div>
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>