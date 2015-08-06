@desc get user payments by product
@tags drupal 7, drupal, commerce

<?php


function get_user_payments_by_product($user_id, $product_id, $order_id = 0) {

  $query = db_select('commerce_payment_transaction', 'commerce_payment_transaction');
  $query->addField('commerce_payment_transaction', 'amount');
  $query->addField('commerce_payment_transaction', 'status');
  $query->addField('commerce_payment_transaction', 'created');
  $query->addField('commerce_order', 'order_id');
  $query->join('commerce_order', 'commerce_order', 'commerce_payment_transaction.order_id = commerce_order.order_id');
  $query->join('commerce_line_item', 'commerce_line_item', 'commerce_order.order_id = commerce_line_item.order_id');
  $query->join('commerce_product', 'commerce_product', 'commerce_line_item.line_item_label = commerce_product.sku');

  $query->condition('commerce_product.product_id', $product_id);
  $query->condition('commerce_payment_transaction.status', 'success');
  $query->condition('commerce_payment_transaction.uid', $user_id);

  if ($order_id) {
    $query->condition('order.order_id', $order_id);
  }

  $result = $query->execute();
  $rows = array();
  foreach ($result as $row) {
    $rows[] = $row;
  }
  return $rows;

}