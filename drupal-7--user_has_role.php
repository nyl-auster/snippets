@tags drupal 7, drupal, roles
@desc  Check if user has one of the roles passed as an array

<?php
/**
 * Check if user has one of the roles passed as an array
 * @param array $roles : array of roles as int (rid stored in database.
 * @param int $user_id : optionnal, default to current user if not defined
 * @return bool
 */
function user_has_role($roles = array(), $user_id = null) {
  if (is_null($user_id)) {
    $user_id = $GLOBALS['user']->uid;
  }
  $user = user_load($user_id);
  if ($user->uid == 1) {
    return TRUE;
  }
  $user_roles = array_keys($user->roles);
  foreach ($roles as $role) {
    if (in_array($role, $user_roles)) {
      return TRUE;
    }
  }
  return FALSE;
}