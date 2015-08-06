@desc number to letter

<?php
function number_to_letter($number) {
  return chr($number + ord('A'));
}