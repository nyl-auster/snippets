@desc Accept terms and conditions
@tags drupal commerce, drupal 7, drupal, conditions de vente, terms and conditions

<?php
/**
 * Implements hook_form_commerce_checkout_form_checkout_alter()
 *
 * @param $form
 * @param $form_state
 */
function daesign_ecommerce_form_commerce_checkout_form_checkout_alter(&$form, $form_state) {
  global $conf;
  $language = $GLOBALS['language']->language;
  $url_conditions = $conf['dae_url_conditions_de_vente'][$language];
  $form['buttons']['continue']['#validate'][] = 'daesign_ecommerce_conditions_de_vente_validate';
  $form['buttons']['dae_terms_and_conditions'] = array(
    '#title' => t("I have read and accept the <a href='@url_conditions'> terms and conditions</a>", array('@url_conditions' => $url_conditions)),
    '#type' => 'checkbox',
    '#required' => TRUE,
    '#weight' => -100
  );
}

function daesign_ecommerce_conditions_de_vente_validate(&$form, &$form_state) {
  if (empty($form_state['values']['dae_terms_and_conditions'])) {
    $form_state['rebuild'] = TRUE;
  }
}