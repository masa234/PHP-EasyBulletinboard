<?php

require (  "../setting_func.php" );
require ( get_require_dir() . "/dbconfig.php" );
require ( get_require_dir() . "/common.php" );
require ( get_require_dir() . "/session.php" );
require ( get_require_dir() . "/user.php" );
require ( get_require_dir() . "/following.php" );
require ( get_require_dir() . "/navbar.php" );

if ( isset( $_POST['action'] ) ) {
    user_delete( $_POST['user_id'] );
}

if ( isset( $_POST['follow'] ) ) {
    follow( $_POST['user_id'] );
}

if ( isset( $_POST['unfollow'] ) ) {
    unfollow( $_POST['user_id'] );
}

$users = pagination( 'users', 'id', 'DESC', 10 );

?>

<?php if ( count( $users ) > 0 ): ?>
<?php foreach ( $users as $user ): ?> 
<?php require ( get_partials_dir() . "/user.php" ); ?>
<?php endforeach; ?>
<?php endif; ?>