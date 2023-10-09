<?php include("head.php"); ?>
<!doctype html>
<html lang="fr">
    <title>ReSoC - Connexion</title> 
    <body>
        <?php include("header.php"); ?>

        <div id="wrapper" >

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenu sur notre réseau social.</p>
            </aside>
            <main>
                <article>
                    <h2>Déconnexion</h2>         
                   <form id="logout"
                    action="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $_SESSION['connected_id'] = null;
                    } ?>"
                    method="post">
                    <input name='logout' value="se déconnecter" type='submit'>
                </form>
    
                </article>
            </main>
        </div>
    </body>
</html>
