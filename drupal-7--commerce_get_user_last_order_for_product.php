@description Get order associated to a product for a specific user.
@tags drupal 7, drupal, commerce, last order

<?php
/**
 * @description Get order associated to a product for a specific user.
 * @tags drupal 7, drupal, commerce, last order
 */

/**
 * Get order associated to a product for a specific user.
 *
 * If there is several orders refering to the same product for the user,
 * we only take the last one that was created for now. This use-case should not be
 * possible for V1 of the platform.
 *
 * @deprecated access are now handled by licence, so this function should not be used anymore.
 */
function commerce_get_user_last_order_for_product($product_id, $user_id = 0) {

  $query = db_select('commerce_order', 'commerce_order');

  $query->addField('commerce_order', 'order_id', 'order_id');
  $query->addField('commerce_order', 'status', 'order_status');
  $query->addField('commerce_order', 'uid', 'order_uid');
  $query->addField('commerce_product', 'product_id');
  $query->addField('commerce_product', 'title', 'product_title');
  $query->addField('commerce_product', 'sku', 'product_sku');

  $query->addField('commerce_line_item', 'line_item_id');
  $query->addField('commerce_line_item', 'line_item_label');

  /*
  $query->addField('commerce_payment_transaction', 'amount', 'transaction_amount');
  $query->addField('commerce_payment_transaction', 'created', 'transaction_created');
  $query->addField('commerce_payment_transaction', 'transaction_id', 'transaction_id');
  $query->addField('commerce_payment_transaction', 'status', 'transaction_status');
  */

  $query->leftJoin('commerce_line_item', 'commerce_line_item', 'commerce_order.order_id = commerce_line_item.order_id');
  $query->leftJoin('commerce_product', 'commerce_product', 'commerce_line_item.line_item_label = commerce_product.sku');


  /*
  $query->leftJoin('commerce_payment_transaction', 'commerce_payment_transaction', 'commerce_payment_transaction.order_id = commerce_order.order_id');
  */

  $query->condition('commerce_order.uid', $user_id);
  $query->condition('commerce_product.product_id', $product_id);

  $query->orderBy('commerce_order.order_id', 'DESC');

  $query->range(0, 1);

  $result = $query->execute()->fetchObject();

  return $result;

}