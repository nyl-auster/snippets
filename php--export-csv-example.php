<?php

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
function csv_convert_all_lines_array_to_string($lines) {
  $csv = '';
  foreach ($lines as $line) {
    $line = (array)$line;
    $csv .= csv_convert_single_line_array_to_string($line);
    $csv .= "\r\n";
  }
  return $csv;
}

/**
 * Transforme une ligne de csv représenté par un array en une string
 * Exemple de tableau attendu pour fields :
 * @code
 * array('name' => 'yann', 'mail' => 'mail@mail.com')
 * @endcode
 * @param array $fields
 * @param string $delimiter
 * @param string $enclosure
 * @param bool $encloseAll
 * @param bool $nullToMysqlNull
 * @return string
 */
function csv_convert_single_line_array_to_string( array &$fields, $delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {

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

function adosspp_commerce_abonnes_csv_page_callback() {

  $datas = _abonnes_get_table_datas();
  if (empty($datas)) {
    return;
  }

  $header = array();
  foreach ($datas['header'] as $item) {
    $header[] = $item['data'];
  }
  $first_line = csv_convert_single_line_array_to_string($header);

  $csv = '';
  $csv .= $first_line;
  $csv .= "\r\n";
  $csv .= csv_convert_all_lines_array_to_string($datas["rows"]);

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

