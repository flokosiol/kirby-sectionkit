<nav role="navigation">

  <ul class="menu cf">
    <?php foreach($pages->filterBy('menu','1') as $p): ?>

      <li>
        <a <?php e($p->isOpen(), ' class="active"') ?> href="<?php echo $p->url() ?>"><?php echo $p->title()->html() ?></a>

        <?php if ($p->hasChildren() && $p->children()->filterBy('menu','1')->count()): ?>
        <ul class="submenu">
          <?php foreach($p->children()->filterBy('menu','1') as $p): ?>
          <li>
            <a href="<?php echo $p->url() ?>"><?php echo $p->title()->html() ?></a>
          </li>
          <?php endforeach ?>
        </ul>
        <?php endif ?>

      </li>
      
    <?php endforeach ?>
  </ul>

</nav>
