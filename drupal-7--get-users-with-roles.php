<?php
$query = 'SELECT DISTINCT(ur.uid) FROM {users_roles} AS ur WHERE ur.rid IN (:rids)';
$result = db_query($query, array(':rids' => array(6)));
$users_uids = $result->fetchCol();
foreach ($users_uids as $user_uid) {
  $uids[$user_uid]['notifiers']['email'] = 'email';
}
