<?php

/**
* Retourne le nid d'un type de contenu "gammes_liste" faisant
* référence à notre contenu de type "gamme".
*
* @param $nid_gamme (int)
* @return int | FALSE
*/
function get_referencing_gammes_liste($nid_gamme) {
  $query = new EntityFieldQuery();
  $entities = $query->entityCondition('entity_type', 'node')
    ->propertyCondition('type', 'gammes_liste')
    ->propertyCondition('status', 1)
    // on onleve "field_data" du nom de la table" et on enleve "field_gammes" du nom de la colonne.
    ->fieldCondition('field_gammes', 'target_id', $nid_gamme)
    ->execute();
  if (!empty($entities['node'])) {
    return reset(array_keys($entities['node']));
  }
  return FALSE;
}

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

/**
 * Récupère la liste des évènements à venir aujourd'hui
 *  * @return bool|mixed
 *   */
function bn_get_today_upcoming_events() {
  $today = date('Y-m-d');
  $now = date('Y-m-d H:i:s');
  $query = new EntityFieldQuery();
  $entities = $query->entityCondition('entity_type', 'node')
    ->propertyCondition('type', 'event')
    ->propertyCondition('status', 1)
    ->fieldCondition('field_event_date', 'value', $today, 'STARTS_WITH')
    ->fieldCondition('field_event_date', 'value', $now, '>')
    ->execute();
  if (!empty($entities['node'])) {
    $nids = array_keys($entities['node']);
    return $nids;
  }
  return array();
}

