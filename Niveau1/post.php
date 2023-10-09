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
                <?php echo $post['content']; ?>
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
                    <input class="like" type='submit' value="♥">
                    <?php echo $post['like_number']; ?>
                </form>
            </small>
            
            <a href="">
                <?php echo ("#" . $post['taglist']); ?>
            </a>,
        </footer>
    </article>
<?php } ?>