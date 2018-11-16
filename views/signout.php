<?php 

require (  "../setting_func.php" );
require ( get_require_dir() . "/dbconfig.php" );
require ( get_require_dir() . "/session.php" );
require ( get_require_dir() . "/navbar.php" );

$_SESSION = array();

header( "Location: authenticate.php" );
exit();