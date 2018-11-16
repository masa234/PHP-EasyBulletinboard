<?php

require (  "../setting_func.php" );
include ( get_functions_dir() . "/dbconfig.php" );
include ( get_functions_dir() . "/common.php" );
include ( get_functions_dir() . "/session.php" );
include ( get_functions_dir() . "/post.php" );
include ( get_views_dir() . "/navbar.php" );

$users = get_all( 'users', 'id', 'DESC' );

foreach ( $users as $user ) {
    require ( get_partials_dir() . "/user.php" );
}