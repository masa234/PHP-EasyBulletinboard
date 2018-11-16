<?php 

require (  "../setting_func.php" );
include ( get_require_dir() . "/dbconfig.php" );
include ( get_require_dir() . "/session.php" );
include ( get_require_dir() . "/navbar.php" );

$_SESSION = array();

header( "Location: authenticate.php" );
exit();