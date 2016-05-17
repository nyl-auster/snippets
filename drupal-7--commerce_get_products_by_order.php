<?php
/**
 * Obtenir tous les produits d'une commande en drupal commerce
 * @param $order
 * @return array
 */
function commerce_get_products_by_order($order) {
  foreach (entity_metadata_wrapper('commerce_order', $order)->commerce_line_items as $delta => $line_item_wrapper) {
    if (in_array($line_item_wrapper->type->value(), commerce_product_line_item_types())) {
      $product_ids[] = $line_item_wrapper->commerce_product->raw();
    }
  }
  return $product_ids;
}