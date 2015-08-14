    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo URL;?>img/intro-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <div class="site-heading">
              <h1>El Blog de Beto</h1>
              <hr class="small">
              <span class="subheading">Estas son las pavadas que me interesan</span>
            </div>
          </div>
        </div>
      </div>
    </header>
    
    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
          <?php foreach($entries as $e){ ?>
          <div class="post-preview">
            <a href="post.php?id=<?php echo $e['id']; ?>">
              <h2 class="post-title">
                <?php echo $e['title']; ?>
              </h2>
              <h3 class="post-subtitle">
                <?php echo substr($e['text'], 0, 50).'...'; ?>
              </h3>
            </a>
            <p class="post-meta">Posteado por <a href="<?php echo URL.$e['author']; ?>"><?php echo $e['author']; ?></a> el <?php echo date_format(date_create($e['date']), 'd-m-Y'); ?></p>
          </div>
          <hr>
          <?php } ?>
          <!-- Pager -->
          <ul class="pager">
            <li class="next">
              <a href="#">Older Posts &rarr;</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
