@desc drupal 7 hook_menu
@tags drupal 7, hook, hook_menu

<?php
/**
 * Implements hook_menu().
 * Create Drupal pages. This map an url to a function.
 */
function modulestarter_menu() {
  $items = array();
  $items['modulestarter-hello'] = array(
    'title' => 'Hello world',
    'page callback' => 'modulestarter_hello_page_callback',
    'access arguments' => array('access content'),
    'type' => MENU_CALLBACK,
  );
  return $items;
}