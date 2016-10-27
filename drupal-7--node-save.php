<?php
$node = new \stdClass();
$node->type = 'userdata';
node_object_prepare($node);

$product_display_node = node_load($this->product_display_id);
$node->title = $this->email . ' - ' . $product_display_node->title;
$node->field_email[LANGUAGE_NONE][0]['value'] = $this->email;
$node->field_uniq_id[LANGUAGE_NONE][0]['value'] = $this->uniq_id;
$node->field_serialize[LANGUAGE_NONE][0]['value'] = $serializedValues;
node_save($node);
