
<?php
while ($post = $lesInformations->fetch_assoc())
                {
                    ?>                
                    <article>
                        <h3>
                            <time><?php echo $post['created']; ?></time>
                        </h3>
                        <address>
                            <a href="wall.php?user_id=<?php echo $post['author_id']?>"><?php echo ("Par " . $post['author_name']); ?></a>
                        </address>
                        <div>
                            <p><?php echo $post['content']; ?></p>
                        </div>
                        <footer>
                            <small><?php echo( "♥ " . $post['like_number']); ?></small>
                            <a href=""><?php echo ( "#" . $post['taglist']); ?></a>, 
                        </footer>
                    </article>
                <?php } ?>