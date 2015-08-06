@desc Get user by username
@tags drupal 7, drupal, user

<?php

function get_user_by_name($name) {
  return db_query("SELECT uid FROM users WHERE name = :name", array(':name' => $name))->fetchField();
}