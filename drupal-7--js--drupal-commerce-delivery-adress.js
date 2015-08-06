@desc jquery delivery information : checkbox and autofill
@tags drupal commerce, drupal 7, drupal, delivery

jQuery(document).ready(function() {
  if (jQuery('#edit-customer-profile-billing-field-delivery-address').length != 0) {

    jQuery('#edit-customer-profile-billing-field-delivery-address').hide();
    jQuery('#edit-customer-profile-billing-field-sameaddress-und-1').attr('onClick','showform()');
    jQuery('#edit-customer-profile-billing-field-sameaddress-und-0').attr('onClick','hideform()');
  }
});

function showform() {
  jQuery('#edit-customer-profile-billing-field-delivery-address').show('slow');
}
function hideform() {
  jQuery('#edit-customer-profile-billing-field-delivery-address').hide('slow');
}