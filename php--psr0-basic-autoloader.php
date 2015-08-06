@desc basic psr0 autoloader
@tags autoloader, psr0

<?php
$includePaths = ['vendors'];

// register a basic PSR-0 autoloader.
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $includePaths));
spl_autoload_register(function($class){require_once str_replace('\\','/', $class).'.php';});