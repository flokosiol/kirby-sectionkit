<?php

class contentlistField extends BaseField {

  public $type = 'text';
  public $min  = 0;
  public $max  = false;

  static public $assets = array(
    'js' => array(
      'contentlist.js'
    ),
    'css' => array(
      'contentlist.css'
    )
  );

  public function inputField($value) {
    $site = site();
    $input = new Brick('input', null);
    $input->addClass('input');
    $input->attr(array(
      'type'         => $this->type(),
      'value'        => $value,
      'required'     => $this->required(),
      'name'         => $this->name() . '[]',
      'autocomplete' => $this->autocomplete() === false ? 'off' : 'on',
      'autofocus'    => $this->autofocus(),
      'readonly'     => $this->readonly(),
      'disabled'     => $this->disabled(),
      'id'           => $this->id()
    ));

    if (!is_array($value)) {
      $input->val(html($value, false));
    }

    if ($this->readonly()) {
      $input->attr('tabindex', '-1');
      $input->addClass('input-is-readonly');
    }

    // Content page doesn't exist anymore?
    if (!$contentPage = $this->page()->find($value)) {
      return FALSE;
    }

    // Show input field as hidden to keep data on page save/update
    $input->addClass('hidden');
    
    // Show list of content pages
    $input .= '<div><a href="' . url('panel/pages/' . $contentPage->uri() . '/edit') . '" class="input input-is-readonly">' . $contentPage->title()->kt() . '</a></div>';
    
    return $input;

  }

  public function item($value, $text) {

    $input = $this->input($value);

    $label = new Brick('input', $this->i18n($text));
    $label->addClass('input');
    $label->attr('data-focus', 'true');
    
    $label->prepend($input);

    if ($this->readonly) {
      $label->addClass('input-is-readonly');
    }

    return $label;

  }

  public function content() {

    return tpl::load(__DIR__ . DS . 'template.php', array('field' => $this));

  }

  public function result() {

    $result = parent::result();
    return yaml::encode($result);

  }

  public function value() {

    $value = parent::value();
    return yaml::decode($value);
    
  }

  public function label() {
    return parent::label();
  }

}


/**
 * Is page a page?
 */
function contentlist_page_is_page($page) {
  if ($page->intendedTemplate() == 'page') {
    return TRUE;
  }
  return FALSE;
}

/**
 * Is page a content element?
 */
function contentlist_page_is_content_type($page) {
  if (strpos($page->intendedTemplate(), '_') === 0) {
    return TRUE;
  }
  return FALSE;
}

/**
 * Get values
 */
function contentlist_get_list_values($page) {
  return yaml::decode($page->contentlist());
}

/**
 * Write values
 */
function contentlist_save_list_values($page, $contentlist) {
  $contentlist = yaml::encode($contentlist);
  try {
    $page->update(
      array(
        'contentlist' => $contentlist,
      )
    );
  }
  catch(Exception $e) {
    return response::error($e->getMessage());
  }
}

/**
 * Hook panel.page.create
 */
kirby()->hook('panel.page.create', function($page) {

  if (contentlist_page_is_content_type($page)) {
    $contentlist = contentlist_get_list_values($page->parent());
    $contentlist[] = $page->uid();
    contentlist_save_list_values($page->parent(), $contentlist);
  }

  if (contentlist_page_is_page($page)) {
    try {
      $page->toggle('last');
    } 
    catch(Exception $e) {
      return response::error($e->getMessage());
    }
  }

});


/**
 * Hook panel.page.update
 */
kirby()->hook('panel.page.update', function($page) {
  
  // Content is updated
  if (contentlist_page_is_content_type($page)) {
    $contentlist = contentlist_get_list_values($page->parent());
    if (!in_array($page->uid(), $contentlist)) {
      $contentlist[] = $page->uid();
      contentlist_save_list_values($page->parent(), $contentlist);  
    }
  }
  
});


/**
 * Hook panel.page.delete
 */
kirby()->hook('panel.page.delete', function($page) {

  if (contentlist_page_is_content_type($page)) {
    $contentlist = contentlist_get_list_values($page->parent());
    if (($key = array_search($page->uid(), $contentlist)) !== false) {
      unset($contentlist[$key]);
    }
    contentlist_save_list_values($page->parent(), $contentlist);
  }

});