@desc Get node list with db_select
@tags drupal 7, db_select

<?php

/**
 * return array of nids.
 */
function get_node_list() {
// choisir la table et les champs que l'on veut récupérer.
// On peut choisir de ne récupérer que le nid et utiliser plus tard
// la fonction drupal node_load_multiple pour charger les nodes.
  $query = db_select('node', 'n');
  $query->addField('n', 'nid');
  $query->addField('n', 'title');
// take care of node access
  $query->addTag('node_access');
// example join for taxonomy of custom fields :
// $query->join('taxonomy_index', 'ti', 'n.nid = ti.nid');
// $query->join('field_data_field_article_date', 'field_date', 'n.nid = field_date.entity_id');
// seulement les articles publiés
  $query->condition('status', 1);
  $query->condition('type', 'article');
//$query->condition('tid', $this->tids, 'IN');
// order by date DESC
  $query->orderBy('created', 'DESC');
// supprimer les doublons si il y en a.
  $query->groupBy('n.nid');
// éxécuter réellement la requete.
  $result = $query->execute();
  $nids = array();
  foreach ($result as $row) {
    $nids[] = $row->nid;
  }
  return $nids;
}