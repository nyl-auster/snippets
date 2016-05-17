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
 * Transforme un csv représenté par un array en une chaine de caractère utilisable
 * Par Excel ou autre.
 */
function export_as_csv($lines) {
  $csv = '';
  foreach ($lines as $line) {
    $line = (array)$line;
    $csv .= array_to_csv_line($line);
  }
  return $csv;
}

