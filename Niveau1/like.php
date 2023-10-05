<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $location = $_POST['location'];

    // se connecter à la bdd
    include("BDD.php");

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


?>