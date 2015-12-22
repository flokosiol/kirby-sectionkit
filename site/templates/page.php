<?php snippet('header') ?>

  <main class="main" role="main">

    <div class="text">
      <h1><?php echo $page->title()->html() ?></h1>
    </div>

    <?php 
      // foreach($page->contentlist()->yaml() as $contentUid) {
      //   if ($content = $page->find($contentUid)) {
      //     echo $content->title();
      //   }
      // }
    
      // Make use of the sections plugin 
      // https://github.com/fenixkim/KirbySections
      sections()->render();
    ?>

  </main>

<?php snippet('footer') ?>