@desc SVN up by php (subversion)
@tags svn, subversion, php

<?php
/**
 * @file svn-up.php
 *
 * execute a "svn up" via php.
 */
// define here the path of the directory you want to update.
$svn_directory = '/home/xxx/xxx/';
// command to execute.
$svn_command = 'svn update';
?>
  <form action="" method="post">
    <div>
      Click here to run <strong><?php print $svn_command ?></strong> <br /> in <?php print $svn_directory ?>
    </div>
    <input name="svn_up_submit" type="submit" value="svn up" />
  </form>
<?php
// execute only if form has bee submitted
if (!isset($_POST['svn_up_submit'])) exit;
$shell = <<<EOD
exec 2>&1
export LANG=en_US.UTF-8
cd $svn_directory
$svn_command
EOD;
$result = shell_exec($shell);
echo "<pre>";
print($result);