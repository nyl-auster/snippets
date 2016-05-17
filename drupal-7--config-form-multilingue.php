<?php
/**
 * Formulaire de config multilingue, drupal 7
 * @return mixed
 */

function pdt_cookie_consent_form() {

  $form = array();

  $languages = language_list();
  foreach ($languages as $language) {

    $lang = $language->language;
    $form[$lang] = array(
      '#type' => "fieldset",
      '#title' => "Configuration pour le language " . $lang,
    );

    $form[$lang]["pdt_cookie_consent_message_$lang"] = array(
      '#title' => 'Message',
      '#type' => 'textfield',
      '#description' => '',
      '#default_value' =>  variable_get("pdt_cookie_consent_message_$lang", "")
    );
  }

  return system_settings_form($form);

}

