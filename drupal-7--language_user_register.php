@desc Add language choice on user register form for Drupal 7
@tags drupal 7, drupal, user preferred language

<?php

global $language;
$form['language'] = array(
  '#type' => (count($names) <= 5 ? 'radios' : 'select'),
  '#title' => t('Language'),
  '#default_value' => $language->language,
  '#options' => $names,
  '#description' => t("Preferred language for you account."),
  // Use exactly the same access logic as the original,
  // without checking for the 'administer users' permission
  '#access' =>  ($form['#user_category'] == 'account' || ($form['#user_category'] == 'register')),
  '#weight' => 50
);