<?php //var_dump($entries); die();?>
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo URL.'data/'.$entries[0]['id']; ?>')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1><?php echo $entries[0]['title']; ?></h1>
                        <h2 class="subheading"></h2>
                        <span class="meta">Posteado por <a href="<?php echo URL.$entries[0]['author']; ?>"><?php echo $entries[0]['author']; ?></a> el <?php echo date_format(date_create($entries[0]['date']), 'd-m-Y'); ?></span>
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
            <?php echo $entries[0]['text']; ?>
          </div>
        </div>
      </div>
    </article>
