<?php
/**
 * Obtenir la dernière actualité épinglée
 */
function actualite_get_single_sticky() {
  $node = NULL;
  $query = new EntityFieldQuery();
  $entities = $query->entityCondition('entity_type', 'node')
    ->propertyCondition('type', 'actualites')
    ->propertyCondition('status', 1)
    ->propertyCondition('sticky', 1)
    ->propertyOrderBy('created', 'DESC')
    ->range(0,1)
    ->execute();
  if (!empty($entities['node'])) {
    $nids = array_keys($entities['node']);
    $node = node_load(reset($nids));
  }
  return $node;
}
