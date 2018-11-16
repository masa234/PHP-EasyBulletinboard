<?php

require (  "../setting_func.php" );
include ( get_require_dir() . "/dbconfig.php" );
include ( get_require_dir() . "/common.php" );
include ( get_require_dir() . "/session.php" );
include ( get_require_dir() . "/user.php" );
include ( get_require_dir() . "/navbar.php" );

$users = get_all( 'users', 'id', 'DESC' );

foreach ( $users as $user ) {
    require ( get_partials_dir() . "/user.php" );
}