<?php

/**
 * Formulaire de configuration pour le consentement des cookies
 * @return mixed
 */
function mazedia_cookie_consent_form() {

  $form = array();

  $languages = language_list();

  foreach ($languages as $language) {
    $lang = $language->language;
    $default_conf = mazedia_cookie_consent_get_default_config($lang);
    $form[$lang] = array(
      '#type' => "fieldset",
      '#title' => "Configuration pour le language " . $lang,
    );

    $form[$lang]["mazedia_cookie_consent_message_main_$lang"] = array(
      '#title' => 'Message principal',
      '#type' => 'textfield',
      '#description' => '',
      '#default_value' =>  variable_get("mazedia_cookie_consent_message_main_$lang", $default_conf['message_main'])
    );

    $form[$lang]["mazedia_cookie_consent_message_dismiss_$lang"] = array(
      '#title' => 'Texte du bouton "annuler"',
      '#type' => 'textfield',
      '#description' => '',
      '#default_value' =>  variable_get("mazedia_cookie_consent_message_dismiss_$lang", $default_conf['message_dismiss'])
    );

    $form[$lang]["mazedia_cookie_consent_message_more_info_$lang"] = array(
      '#title' => 'Texte du lien "plus d\'infos"',
      '#type' => 'textfield',
      '#description' => '',
      '#default_value' =>  variable_get("mazedia_cookie_consent_message_more_info_$lang", $default_conf['message_more_info'])
    );

    $form[$lang]["mazedia_cookie_consent_more_info_link_$lang"] = array(
      '#title' => 'Lien de la page "plus d\infos"',
      '#type' => 'textfield',
      '#description' => '',
      '#default_value' =>  variable_get("mazedia_cookie_consent_more_info_link_$lang", $default_conf['more_info_link'])
    );

  }

  return system_settings_form($form);

}