<?php
$marequete = "SELECT * FROM followers WHERE following_user_id= $_SESSION[connected_id] AND  followed_user_id='$userId'";
$reponse = $mysqli->query($marequete);
echo "<pre>" . print_r($reponse, 1) . "</pre>";
if ($_SESSION['connected_id'] != null && $userId != $_SESSION['connected_id'] && mysqli_num_rows($reponse) == 0) { ?>
    <form action="<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $followed_user_id = $_POST['followed_user_id'];
        $following_user_id = $_POST['following_user_id'];

        $lInstructionSql = 'INSERT INTO followers'
            . '(id, followed_user_id, following_user_id)'
            . 'VALUES (NULL, '
            . $followed_user_id . ', '
            . $following_user_id . ');';
        $ok = $mysqli->query($lInstructionSql);
    } ?>" method="post">
        <input type='hidden' name='followed_user_id' value="<?php echo $userId; ?>">
        <input type='hidden' name='following_user_id' value="<?php echo $_SESSION['connected_id']; ?>">

        <input type='submit' value="S'abonner">
    </form>
<?php }
if ($_SESSION['connected_id'] != null && $userId != $_SESSION['connected_id'] && mysqli_num_rows($reponse) > 0) { ?>
    <form action="<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $followed_user_id = $_POST['followed_user_id'];
        $following_user_id = $_POST['following_user_id'];

        $lInstructionSql = "DELETE FROM `followers` WHERE `followers`.`following_user_id` ='$following_user_id' AND `followers`.`followed_user_id` = '$followed_user_id'";

        $ok = $mysqli->query($lInstructionSql);
    } ?>" method="post">
        <input type='hidden' name='followed_user_id' value="<?php echo $userId; ?>">
        <input type='hidden' name='following_user_id' value="<?php echo $_SESSION['connected_id']; ?>">

        <input type='submit' value="Se désabonner">
    </form>
<?php } ?>