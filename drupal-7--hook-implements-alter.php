@desc drupal 7 hook_module_implements_alter
@tags drupal 7, hook, hook_module_implements_alter

<?php
/**
 * Implements hook_module_implements_alter()
 * @param $implementations
 * @param $hook
 */
function mymodule_module_implements_alter(&$implementations, $hook) {
  $module = 'mymodule';
  if ($hook == 'user_login') {
    $group = $implementations[$module];
    unset($implementations[$module]);
    $implementations[$module] = $group;
  }
}