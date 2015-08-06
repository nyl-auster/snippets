@desc example db_query
@tags drupal 7, drupal, db_query

<?php
function daesign_lms_get_user_trainings() {
  $query = "SELECT node.nid FROM {node} node
  JOIN {field_data_field_dae_product_reference} product_reference ON product_reference.field_dae_product_reference_product_id = node.nid
  JOIN {lms_training_state training} ON product_reference.field_dae_product_reference_product_id = training.training_id
  WHERE node.type = :node_type
  ";
  $result = db_query($query, array(':node_type' => 'dae_serious_game_display'));
  $datas = $result->fetchAllAssoc('nid');
  return $datas;
}