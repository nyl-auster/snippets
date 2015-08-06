@desc Example code to build a csv from user tables
@tags drupal 7, drupal, users export, users csv

<?php
/**
 * Example code to build a csv from user tables
 */
/***************************
 * HOOKS
 ***************************/
/**
 * Implements hook_menu()
 */
function neuflize_users_export_menu() {
  $items = array();
// add a tab to download csv file on people page.
  $items['admin/people/neuflize-users-export.csv'] = array(
    'title' => 'Export users to CSV',
    'page callback' => 'neuflize_users_export_csv_download',
    'access arguments' => array('access administration pages'),
    'type' => MENU_LOCAL_TASK,
  );
  return $items;
}
/***************************
 * API
 ***************************/
/**
 * Get datas we want for csv from our users table.
 */
function neuflize_users_export_get_users($options = array()) {
// get columns from users table
  $query = db_select('users', 'u');
  $query->fields('u');
// join all custom fields table for users, and add theirs columns to our select.
  $custom_tables = array(
    'field_data_field_user_adresse',
    'field_data_field_user_cat_client',
    'field_data_field_user_client_obc',
    'field_data_field_user_code_postal',
    'field_data_field_user_fonction',
    'field_data_field_user_nom',
    'field_data_field_user_pays',
    'field_data_field_user_prenom',
    'field_data_field_user_private_assets',
    'field_data_field_user_societe',
    'field_data_field_user_tel',
    'field_data_field_user_ville',
  );
  foreach ($custom_tables as $custom_table) {
    $query->leftJoin($custom_table, $custom_table, "u.uid = $custom_table.entity_id");
    $query->fields($custom_table);
  }
  $result = $query->execute();
  $datas = array();
  foreach ($result as $user) {
    if ($user->uid == 0) continue;
    $datas[$user->uid] = array(
      'User id'=> $user->uid,
      'Nom' => $user->field_user_nom_value,
      'Prenom' => $user->field_user_prenom_value,
      'Mail'=> $user->mail,
      'Telephone'=> $user->field_user_tel_value,
      'Adresse' => $user->field_user_adresse_value,
      'Code postal' =>$user->field_user_code_postal_value,
      'Ville' => $user->field_user_ville_value,
      'Categorie client' => neuflize_users_export_format_categorie_client($user->field_user_cat_client_value),
      'Client Obc' => neuflize_users_export_format_is_client($user->field_user_client_obc_value),
      'Client Npa' => neuflize_users_export_format_is_client($user->field_user_private_assets_value),
      'Societe' => $user->field_user_client_societe_value,
      'Fonction' => $user->field_user_fonction_value,
      'Pays' => $user->field_user_pays_value,
      "Date d'inscription" => format_date($user->created, 'custom', 'd/m/Y'),
    );
  }
  return $datas;
}
/**
 * Render csv from datas fetched bu neuflize_users_export_get_users()
 */
function neuflize_users_export_csv_render($datas, $options = array()) {
  $conf = $options + array(
      'header' => TRUE,
      'quotes' => '"',
      'separator' => ';',
      'end_of_line' => "\r\n",
    );
  if ($conf['header']) {
    array_unshift($datas, array_keys(reset($datas)));
  }
  $lines = array();
  foreach ($datas as $row) {
    foreach ($row as &$cell) {
      $cell = str_replace($conf['quotes'], '', $cell);
      $cell = str_replace($conf['separator'], '', $cell);
      $cell = str_replace($conf['end_of_line'], '', $cell);
      $cell = sprintf("%s%s%s", $conf['quotes'], $cell, $conf['quotes']);
    }
    $lines[] = implode($conf['separator'], $row) . $newline;
  }
  return implode($conf['end_of_line'], $lines);
}
/**
 * Menu callback for admin/people/neuflize-users-export
 *
 * Let admin download a csv file of existing users.
 */
function neuflize_users_export_csv_download($csv) {
  $datas = neuflize_users_export_get_users();
  $csv = neuflize_users_export_csv_render($datas);
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private",false); // required for certain browsers
  header("Content-Type: application/csv;charset=utf-8");
  header("Content-Disposition: attachment;" );
  header("Content-Transfer-Encoding: binary");
  print $csv;
  drupal_exit();
}
/***************************
 * Helpers functions
 ***************************/
/**
 * Format field_user_categorie_client value.
 */
function neuflize_users_export_format_categorie_client($id) {
  $categories = array(
    1 => 'Tiers distributeur',
    2 => 'Conseiller en gestion de patrimoine',
    3 => 'Institutionnel',
    4 => 'Particulier',
    5 => 'Autre',
  );
  return isset($categories[$id]) ? $categories[$id] : '';
}
/**
 * Format field_user_client_obc_value value.
 */
function neuflize_users_export_format_is_client($id) {
  $categories = array(
    0 => 'Non',
    1 => 'Oui',
  );
  return isset($categories[$id]) ? $categories[$id] : '';
}