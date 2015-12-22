<?php if ($page->hasImages()): ?>
  <?php foreach($page->images()->sortBy('sort', 'asc') as $image): ?>
    <figure>
      <img src="<?php echo $image->url() ?>" alt="<?php echo $image->name() ?>" >
    </figure>
  <?php endforeach ?>
<?php endif ?>