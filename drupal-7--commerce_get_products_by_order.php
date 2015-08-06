@desc Drupal 7, Drupal commerce, get products from an order
@tags drupal 7, drupal, drupal commerce

<?php

function commerce_get_products_by_order($order) {
  foreach (entity_metadata_wrapper('commerce_order', $order)->commerce_line_items as $delta => $line_item_wrapper) {
    if (in_array($line_item_wrapper->type->value(), commerce_product_line_item_types())) {
      $product_ids[] = $line_item_wrapper->commerce_product->raw();
    }
  }
  return $product_ids;
}