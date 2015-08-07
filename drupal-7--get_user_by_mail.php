@desc drupal 7 get user by mail
@tags drupal 7

<?php

function get_user_by_mail($mail) {
  return db_query("SELECT uid FROM users WHERE mail = :mail", array(':mail' => $mail))->fetchField();
}
