<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $author_id = $_POST['author_id'];
    $location = $_POST['location'];
    // ne rien faire si l'utilisateur souhaite liker son propre post
    if ($user_id === $author_id) {
        header("Location:$location");
        exit();
    } else {
        // se connecter à la bdd
        include("BDD.php");

        // vérifier que l'utilisateur n'a pas déjà liké ce post
        $marequete = "SELECT * FROM likes WHERE user_id='$user_id' AND post_id='$post_id' ";
        $reponse = $mysqli->query($marequete);
        if (mysqli_num_rows($reponse) == 0) {
            // requête SQL pour ajouter un like
            $lInstructionSql = "INSERT INTO likes "
                . "(id, user_id, post_id) "
                . "VALUES (NULL, "
                . $user_id . ", "
                . $post_id . ")"
            ;
            $mysqli->query($lInstructionSql);

            header("Location:$location");
            exit();
        } 
        else {
             // requête SQL pour ajouter un like
             $lInstructionSql = "DELETE FROM `likes` WHERE user_id='$user_id' AND post_id='$post_id' ";
         ;
         $mysqli->query($lInstructionSql);
            header("Location:$location");
            exit();
            
        }
    }
}


?>