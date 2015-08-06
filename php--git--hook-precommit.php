@desc Git hook pre commit Run script or tests before a commit
@tags git, pre commit, pre-commit, commit

#!/usr/bin/php
<?php
/**
 * put this in a .git/hooks/pre-commit file.
 * Adjust projet and testFile variables to suit your needs.
 * Don't forget to make your pre-commit file executable !
 */
// Hook configuration
$project = 'OKC Framework';
$testFile = 'tests/okcTests.php';
// Tell the commiter what the hook is doing
echo PHP_EOL;
echo '=== Starting unit tests ===';
echo PHP_EOL;
// Execute project unit tests
exec("phpunit $testFile", $output, $returnCode);
// if the build failed, output a summary and fail
if ($returnCode !== 0) {
  echo '+ Test suite for '.$project.' failed:'.PHP_EOL;
  echo implode(PHP_EOL, $output);
  echo PHP_EOL;
  exit(1);
}
echo '+ All tests for '.$project.' passed !'.PHP_EOL;
echo PHP_EOL;
exit(0);