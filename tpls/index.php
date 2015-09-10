    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <?php foreach (V::get('posts') as $p) { ?>
                <div class="post-preview">
                    <a href="post.php?id=<?php echo $p['id'];?>">
                        <h2 class="post-title"><?php echo $p['title'];?></h2>
                        <h3 class="post-subtitle"><?php echo $p['subtitle'];?></h3>
                    </a>
                    <p class="post-meta">Posted by <a href="#"><?php echo $p['author'];?></a> on <?php echo substr($p['date'], 0, 10);?></p>
                </div>
                <hr>
                <?php } ?>
                <!-- Pager -->
                <ul class="pager">
                    <li class="next">
                        <a href="allposts.php">Older Posts &rarr;</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <hr>