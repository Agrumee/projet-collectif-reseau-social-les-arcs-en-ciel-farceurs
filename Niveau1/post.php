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

                <!-- problème à résoudre : la boucle While attribue les likes à tous les posts qui apparaissent sur la page. -->
                <form method="post" action="<?php $lInstructionSql = "INSERT INTO likes "
                    . "(id, user_id, post_id) "
                    . "VALUES (NULL, "
                    . $_SESSION['connected_id'] . ", "
                    . $post['num_post'] . ");"
                ;
                $ok = $mysqli->query($lInstructionSql); ?>">
                    <input type='hidden' name='???' value='achanger'>

                    <input id="like" type='submit' value="♥">
                    <?php

                    echo ($post['like_number']); ?>

                </form>
            </small>

            <a href="">
                <?php echo ("#" . $post['taglist']); ?>
            </a>,
        </footer>
    </article>
<?php } ?>