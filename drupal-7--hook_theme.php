@desc drupal 7 hook_theme
@tags drupal 7, drupal, hook, hook_theme

<?php

/**
 * Implements hook_theme().
 * Declare templates to Drupal.
 */
function modulestarter_theme() {
  return array(
    'modulestarter_article_list' => array(
      'variables' => array('articles' => array()),
      'template' => 'templates/modulestarter_article_list',
    ),
  );
}