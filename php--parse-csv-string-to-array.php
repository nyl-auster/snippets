@desc Parse a csv string to a php array
@tags csv

<?php
/**
 * Create a php array from a csv string.
 *
 * @param string $csv_string
 * @return array
 */
function parse_csv_string_to_array($csv_string) {
  $lines = explode(PHP_EOL, $csv_string);
  $header = str_getcsv(array_shift($lines), YOUR_CSV_SEPARATOR);
  $array = array();
  foreach ($lines as $line) {
    if ($line) {
      $line_array = str_getcsv($line, YOUR_CSV_SEPARATOR);
      // try remove empty lines with array filter
      if (array_filter($line_array)) {
        $array[] = $line_array;
      }
    }
  }
  return $array;
}