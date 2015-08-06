@desc drupal 7 hook_block_*
@tags drupal 7, hook, hook_block

<?php

/**
 * Implements hook_block_info()
 * Declares block to Drupal
 */
function modulestarter_block_info() {
  return array(
    'modulestarter_article_list' => array(
      'info' => t('Module starter example block'),
    ),
  );
}
/**
 * Implements hook_block_view();
 * Define what a block defined in hook_block_info has to display
 */
function modulestarter_block_view($delta) {
  $block = array();
  if ($delta == 'modulestarter_article_list') {
// appelle de notre classe métier pour générer le contenu d'un bloc
    $article = new modulestarter_article();
    $block['subject'] = t('Module starter example block');
// #theme is the template to used for rendering.
// #articles and others keys will be arguments passed to the theme function.
// @see hook_theme
    $block['content'] = array(
      '#theme' => 'modulestarter_article_list',
      '#articles' => node_load_multiple($article->get_list()),
    );
  }
  return $block;
}
/**
 * Implements hook_block_configure()
 */
function modulestarter_block_configure($delta = '') {
  $form = array();
  if ($delta == 'modulestarter_article_list') {
    $form['modulestarter_config'] = array(
      '#type' => 'textarea',
      '#title' => t('Configuration'),
      '#default_value' => variable_get('modulestarter_config', 'Default value'),
      '#rows' => 5,
    );
  }
  return $form;
}
/**
 * Implements hook_block_save()
 */
function modulestarter_block_save($delta = '', $edit = array()) {
  if ($delta == 'modulestarter_article_list') {
    variable_set('modulestarter_config', $edit['modulestarter_config']);
  }
}