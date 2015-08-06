@desc Example of code to redirect a user just after he logged in.
@tags drupal 7, drupal, redirect, user

<?php
/**
 * Example of code to redirect a user just after he logged in.
 */
/**
 * Implements hook_user_login()
 */
function hook_user_login(&$edit, $account) {
// Do not redirect if the user is trying to reset his password.
  if (!isset($_POST['form_id']) || $_POST['form_id'] != 'user_pass_reset') {
    $_GET['destination'] = '<front>';
  }
}

/**
 * Implements hook_user_login()
 *
 * Redirect user to url of our choice on login.
 */
function hook_user_login(&$edit, $account) {
  // Do not redirect if the user is trying to reset his password.
  if (!isset($_POST['form_id']) || $_POST['form_id'] != 'user_pass_reset') {
    if (in_array(RF_ROLE_WEBMASTER, array_keys($account->roles))) {
      $_GET['destination'] = 'admin/irp-dashboard';
    }
    elseif (in_array(RF_ROLE_CONTRIB_PRESSE, array_keys($account->roles))) {
      $_GET['destination'] = 'admin/irp-dashboard';
    }
  }
}