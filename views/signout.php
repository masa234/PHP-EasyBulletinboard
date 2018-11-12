<?php 

require (  "../setting_func.php" );
include ( get_functions_dir() . "/dbconfig.php" );
include ( get_functions_dir() . "/session.php" );
include ( get_functions_dir() . "/user.php" );
include ( get_views_dir() . "/navbar.php" );

$_SESSION = array();

header( "Location: authenticate.php" );
exit();