@desc get revision list
@tags drupal 7, drupal, node revisions, revision


<?php
/**
 * drupal 7 get node revisions lists
 *
 * Custom query to get node revision informations needed for search results page.
 * @param $node
 * @return array
 */
function get_node_revision_list($node) {
  $revisions = array();

  $result = db_query('
  SELECT r.vid, r.title, r.log, r.uid, n.vid AS current_vid, r.timestamp, u.name, file.filesize, file.filename
  FROM {node_revision} r
  LEFT JOIN {node} n ON n.vid = r.vid
  INNER JOIN {users} u ON u.uid = r.uid
  LEFT JOIN {field_revision_field_ubi_file} field_file ON r.vid = field_file.revision_id
  LEFT JOIN {file_managed} file ON field_file.field_ubi_file_fid = file.fid
  WHERE r.nid = :nid
  ORDER BY r.vid DESC',
    array(':nid' => $node->nid)
  );

  foreach ($result as $revision) {
    $revisions[$revision->vid] = $revision;
    $revisions[$revision->vid]->nid = $node->nid;
  }

  return $revisions;
}
