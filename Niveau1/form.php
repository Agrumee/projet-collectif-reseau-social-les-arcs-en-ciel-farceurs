<?php
                    /**
                     * BD
                     */
                    /**
                    * Etape 2: se connecter à la base de donnée
                    */
                    include("BDD.php");
                    // $mysqli = new mysqli("localhost", "root", "root", "socialnetwork_tests");
                    /**
                     * Récupération de la liste des auteurs
                     */
                    
                    $laQuestionEnSql = "SELECT * FROM users WHERE id= '1' "
                    $user = $mysqli->query($laQuestionEnSql);
                    print_r ($user);


                    /**
                     * TRAITEMENT DU FORMULAIRE
                     */
                    // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
                    // si on recoit un champs email rempli il y a une chance que ce soit un traitement
                    $enCoursDeTraitement = isset($_POST['message']);
                    if ($enCoursDeTraitement)
                    {
                        // on ne fait ce qui suit que si un formulaire a été soumis.
                        // Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
                        // observez le résultat de cette ligne de débug (vous l'effacerez ensuite)
                        echo "<pre>" . print_r($_POST, 1) . "</pre>";
                        // et complétez le code ci dessous en remplaçant les ???
                        
                        $postContent = $_POST['message'];


                        //Etape 3 : Petite sécurité
                        // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                        
                        $postContent = $mysqli->real_escape_string($postContent);
                        //Etape 4 : construction de la requete
                        $lInstructionSql = "INSERT INTO posts "
                            . "(id, user_id, content, created, parent_id) "
                            . "VALUES (NULL, "
                            . 1 . ", "
                            . "'" . $postContent . "', "
                            . "NOW(), "
                            . "NULL);"
                            ;
                        //echo $lInstructionSql;
                        // Etape 5 : execution
                        $ok = $mysqli->query($lInstructionSql);
                        if ( ! $ok)
                        {
                            echo "Impossible d'ajouter le message: " . $mysqli->error;
                        }
                    }
                    ?>                     
                    <form action="form.php" method="post">
                        <input type='hidden' name='???' value='achanger'>
                        <dl>
                           
                    <dt><label for='message'>Message</label></dt>
                            
                    <dd><textarea name='message'></textarea></dd>
                        </dl>
                        <input type='submit'>
                    </form> 

$_SESSION['connected_id']