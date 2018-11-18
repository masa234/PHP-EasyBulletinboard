<?php

require (  "../setting_func.php" );
require ( get_require_dir() . "/dbconfig.php" );
require ( get_require_dir() . "/common.php" );
require ( get_require_dir() . "/session.php" );
require ( get_require_dir() . "/user.php" );
require ( get_require_dir() . "/navbar.php" );

$users = pagination( 'users', 'id', 'DESC', 10 );

foreach ( $users as $user ) {
    require ( get_partials_dir() . "/user.php" );
}