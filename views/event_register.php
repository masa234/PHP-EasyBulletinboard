<?php 
// イベント登録画面

require (  "../setting_func.php" );
require ( get_functions_dir() . "/dbconfig.php" );
require ( get_functions_dir() . "/session.php" );
require ( get_functions_dir() . "/user.php" );

require_adminAuthenticate();
include ( get_views_dir() . "/navbar.php" );