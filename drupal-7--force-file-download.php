@desc example code to force download of a file with Drupal
@tags drupal 7, drupal, file download, download

<?php

/**
 * example code to force download of a file with Drupal
 */
/**
 * Implementation of hook_menu()
 */
function mymodule_menu() {
  $items['download/%file'] = array(
    'page callback' => 'mymodule_download_file',
    'page arguments' => array(1),
    'access arguments' => array('access content'),
    'type' => MENU_CALLBACK,
  );
  return $items;
}
/**
 * Page callback for forcing a file to download
 */
function mymodule_download_file($file) {
  if($file) {
    $headers = array('Content-Type' => 'application/octet-stream',
      'Content-Disposition' => 'attachment; filename="' . $file->filename . '"',
      'Content-Length' => $file->filesize);
    file_transfer($file->uri, $headers);
  }
  else {
    return drupal_access_denied();
  }
}