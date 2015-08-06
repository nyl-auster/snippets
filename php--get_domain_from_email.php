@desc get domain from email
@tags email, mail

<?php

/**
 * Get domain from email

 * @param $email
 * @return string
 */
function get_domain_from_email($email) {
  // Get the data after the @ sign
  $domain = substr(strrchr($email, "@"), 1);
  return $domain;
}