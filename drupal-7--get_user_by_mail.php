@desc drupal 7 get user by mail
@tag drupal 7, user

<?php

function get_user_by_mail($mail) {
  return db_query("SELECT uid FROM users WHERE mail = :mail", array(':mail' => $mail))->fetchField();
}
