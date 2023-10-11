<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>
<?php if ($userId == $_SESSION['connected_id']) {
    ?>
    <article>
        <h2>Poster un message</h2>
        <?php
        include("BDD.php");
        // * TRAITEMENT DU FORMULAIRE
        // */
        // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
        // si on recoit un champs email rempli il y a une chance que ce soit un traitement
        $enCoursDeTraitement = isset($_POST['message']);
        if ($enCoursDeTraitement) {
            // On ne fait ce qui suit que si un formulaire a été soumis.
            // Etape 2: récupérer ce qu'il y a dans le formulaire
            $postContent = $_POST['message'];
            // Etape 3 : formatage des données entrées par l'utilisateur
            $postContent = $mysqli->real_escape_string($postContent);
            // Etape 4 : construction de la requete
            $lInstructionSql = "INSERT INTO posts (id, user_id, content, created, parent_id) VALUES (NULL, "
                . $userId . ", '"
                . $postContent . "', NOW(), NULL)";
            // Etape 5 : execution
            $ok = $mysqli->query($lInstructionSql);
            if (!$ok) {
                echo "Impossible d'ajouter le message: " . $mysqli->error;
            } else {
                // Récupère l'ID du post inséré
                $postId = $mysqli->insert_id;
                // Découper le post en tableau
                $postContentArray = explode(" ", $postContent);
                // Chercher tous les tags présents dans le tableau généré et les stocker dans un nouveau tableau en supprimant la ponctuation accolée
                $tagArray = [];
                foreach ($postContentArray as $word) {
                    if (substr($word, 0, 1) === "#") {
                        $formatedWord = str_replace(array(',', ';', '!', ' ', '#'), '', $word);
                        array_push($tagArray, $formatedWord);
                    }
                };
                // Récupérer la liste des tags existants
                $sql = "SELECT * FROM tags";
                $result = $mysqli->query($sql);
                while ($tag = mysqli_fetch_array($result)) {
                    $existingTags[] = $tag['label'];
                }

                foreach ($tagArray as $postTag) {
                    // si un tag n'existe pas, le créer.
                    if (!in_array($postTag, $existingTags)) {
                        $mysqli->query("INSERT INTO tags (id, label) VALUES (NULL, '$postTag')");
                    }
                }

                // Récupérer la liste des tags existants
                $sql = "SELECT * FROM tags";
                $result = $mysqli->query($sql);
                while ($tag = $result->fetch_assoc()) {
                    $tagLabel = '#' . $tag['label'];
                    // Vérifier si le tag est présent dans le contenu du message
                    if (strpos($postContent, $tagLabel) !== false) {
                        $insertSql = "INSERT INTO posts_tags (id, post_id, tag_id) VALUES (NULL, '$postId', '$tag[id]')";
                        $mysqli->query($insertSql);
                    }
                }
            }

        }
        ?>
        <form method="post">
            <input type='hidden' name='???' value='achanger'>
            <dl>
                <dt><label for='message'>Message</label></dt>
                <dd><textarea name='message'></textarea></dd>
            </dl>
            <input type='submit'>
        </form>
    </article>
<?php } ?>