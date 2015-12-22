
<div class="list-field" data-field="list" data-sortable="true">
  
  <script class="list-item-template" type="text/x-handlebars-template">
    <div class="list-item">
      <?php echo $field->inputField(''); ?>
      <div class="field-icon sortable-handle"><i class="icon fa fa-arrows"></i></div>
    </div>

  </script>

  <div class="list">
    <?php foreach ($field->value() as $listItemValue): ?>
      <?php if ($field->inputField($listItemValue)): ?>
        <div class="list-item">
          <?php echo $field->inputField($listItemValue); ?>
          <?php if (!$field->disabled()): ?>
            <div class="field-icon sortable-handle"><i class="icon fa fa-arrows"></i></div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php endforeach ?>
  </div>

  <?php if (!$field->disabled()): ?>
  <div class="hgroup-options shiv shiv-dark shiv-left">
    <div class="hgroup-option-right">

      <a title="+" data-shortcut="+" data-modal href="<?php echo purl($field->page(), 'add') ?>">
        <?php i('plus-circle', 'left') ?><span><?php echo l::get('pages.show.subpages.add') ?></span>
      </a>

    </div>

  </div>
  <?php endif ?>

</div>