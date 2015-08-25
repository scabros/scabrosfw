    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo UPLOADS.$post['image'];?>')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1><?php echo $post['title'];?></h1>
                        <h2 class="subheading"><?php echo $post['title'];?></h2>
                        <span class="meta">Posted by <a href="#"><?php echo $post['author'];?></a> on <?php echo substr($post['date'], 0, 10);?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                  <?php echo $post['text'];?>
                </div>
            </div>
        </div>
    </article>

    <hr>
