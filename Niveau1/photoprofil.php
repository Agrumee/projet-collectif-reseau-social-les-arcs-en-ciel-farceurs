<?php
echo "<div class = 'cropped'>";
$laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId'";
$lesInformations = $mysqli->query($laQuestionEnSql);
$reponse = $lesInformations->fetch_assoc();

if ($reponse['photo'] != "0") {
    echo "<img src='" . $reponse['photo'] . "'" . "alt='Photo de Profil' />";
} else {
    echo "<img src='user.jpg'" . "alt='Photo de Profil' />";

}
echo "</div>"
    ?>