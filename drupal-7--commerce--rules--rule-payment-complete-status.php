{ "example_payment_complete_status" : {
    "LABEL" : "example_payment_complete_status ( passer \u00e0 termin\u00e9 m\u00eame si on utilise le paiement d\u0027exemple)",
    "PLUGIN" : "reaction rule",
    "WEIGHT" : "10",
    "OWNER" : "rules",
    "REQUIRES" : [ "commerce_payment", "commerce_order", "commerce_checkout" ],
    "ON" : { "commerce_checkout_complete" : [] },
    "IF" : [
      { "commerce_payment_selected_payment_method" : {
          "commerce_order" : [ "commerce_order" ],
          "method_id" : "commerce_payment_example"
        }
      }
    ],
    "DO" : [
      { "commerce_order_update_status" : { "commerce_order" : [ "commerce_order" ], "order_status" : "completed" } }
    ]
  }
}
