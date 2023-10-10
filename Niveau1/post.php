<?php
while ($post = $lesInformations->fetch_assoc()) {
    ?>
    <article>
        <h3>
            <time>
                <?php echo $post['created']; ?>
            </time>
        </h3>
        <address>
            <a href="wall.php?user_id=<?php echo $post['author_id'] ?>">
                <?php echo ("Par " . $post['author_name']); ?>
            </a>
        </address>
        <div>
            <p>
                <?php echo nl2br($post['content']);
                ?>
            </p>
        </div>
        <footer>
            <small>
                <form method="post" action='like.php'>
                    <input type='hidden' name='location'
                        value='<?php echo ($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']); ?>'>
                    <input type='hidden' name='post_id' value='<?php echo $post['postId']; ?>'>
                    <input type='hidden' name='user_id' value='<?php echo $_SESSION['connected_id']; ?>'>
                    <input type='hidden' name='author_id' value='<?php echo $post['author_id']; ?>'>
                    <input type='submit' value="<?php $marequete = "SELECT * FROM likes WHERE user_id='$_SESSION[connected_id]' AND post_id='$post[postId]' ";
                            $reponse = $mysqli->query($marequete);
                            if (mysqli_num_rows($reponse) == 0) {
                                echo"♡"; 
                            }
                            else {
                                echo"♥";
                            }?>">
                    <?php echo $post['like_number']; ?>
                </form>
            </small>
            <?php
            foreach (explode (",", $post['taglist']) as &$label) { ?>
            <?php 
                $marequete = "SELECT * FROM tags WHERE label='$label'";
                $reponse = $mysqli->query($marequete);
                $tag = $reponse->fetch_assoc();
            ?>
            <a href='tags.php?tag_id=<?php echo ($tag['id']) ?>'>
                <?php 
                if ($label != null) {
                    echo("#" . $label); 
                }
                else echo("<br>")?>
            </a>
            <?php } ?>
        </footer>
    </article>
<?php } ?>