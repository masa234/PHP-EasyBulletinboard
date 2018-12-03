<?php 

require (  "../setting_func.php" );

$_SESSION = array();

header( "Location: authenticate.php" );
exit();