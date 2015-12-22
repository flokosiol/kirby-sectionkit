<?php if ($content->hasImages()): ?>
  <?php foreach($content->images()->sortBy('sort', 'asc') as $image): ?>
    <figure>
      <img src="<?php echo $image->url() ?>" alt="<?php echo $image->name() ?>" >
    </figure>
  <?php endforeach ?>
<?php endif ?>