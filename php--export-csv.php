<?php
/**
 * Formats a line (passed as an array) as CSV and returns the CSV as a string.
 * Adapted from http://us3.php.net/manual/en/function.fputcsv.php#87120
 */
function array_to_csv_line( array &$fields, $delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
  $delimiter_esc = preg_quote($delimiter, '/');
  $enclosure_esc = preg_quote($enclosure, '/');

  $output = array();
  foreach ( $fields as $field ) {
    if ($field === null && $nullToMysqlNull) {
      $output[] = 'NULL';
      continue;
    }

    // Enclose fields containing $delimiter, $enclosure or whitespace
    if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
      $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
    }
    else {
      $output[] = $field;
    }
  }

  return implode( $delimiter, $output );
}

/**
 * converti un csv représenté par un array en une string importable par Excel ou autre.
 * exemple de tableau lines attendu en entrée :
 * @code
 * array(
 *   array('name' => 'yann', 'mail' => 'mail@mail.com'),
 *   array('name' => 'spinoza', 'mail' => 'spinoza@caramail.com'),
 * );
 * @encode
 * @param $lines
 * @return string
 */
function csv_array_to_string($lines) {
  $csv = '';
  foreach ($lines as $line) {
    $line = (array)$line;
    $csv .= array_to_csv_line($line);
  }
  return $csv;
}

function download_csv() {
  $datas = abonnes_get_all();
  if (!$datas) {
    return;
  }
  $csv = csv_array_to_string($datas);
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private",false); // required for certain browsers
  header("Content-Type: application/csv;charset=utf-8");
  header('Content-Disposition: attachment; filename="export.csv"');
  header("Content-Transfer-Encoding: binary");
  print $csv;
  drupal_exit();
}


