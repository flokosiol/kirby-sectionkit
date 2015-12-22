<?php snippet('header') ?>

  <main class="main" role="main">

    <div class="text">
      <h1><?php echo $page->title()->html() ?></h1>
    </div>

    <?php 
      foreach($page->contentlist()->yaml() as $contentUid) {
        if ($content = $page->find($contentUid)) {
          snippet('content/' . $content->intendedTemplate(), array('content' => $content));
        }
      }
    ?>

  </main>

<?php snippet('footer') ?>