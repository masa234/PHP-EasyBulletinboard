<?php

require (  "../setting_func.php" );
require ( get_require_dir() . "/dbconfig.php" );
require ( get_require_dir() . "/common.php" );
require ( get_require_dir() . "/session.php" );
require ( get_require_dir() . "/user.php" );
require ( get_require_dir() . "/following.php" );
require ( get_require_dir() . "/like.php" );
require ( get_require_dir() . "/navbar.php" );


var_dump( $_POST );
if ( is_Submit() ) {
    user_delete( get_Post( 'delete_id' ) );
}

if ( is_Submit( 'follow' ) ) {
    follow( get_Post( 'follow_id' ) );
}

if ( is_Submit( 'unfollow' ) ) {
    unfollow( get_Post( 'unfollow_id' ) );
}

$query = "SELECT * FROM users ORDER BY id DESC";
$result = query( $query );

$users = pagination( $result['datas'], 10 );

?>

<?php if ( count( $users ) > 0 ): ?>
<?php foreach ( $users as $user ): ?> 
<?php require ( get_partials_dir() . "/user.php" ); ?>
<?php endforeach; ?>
<?php endif; ?>