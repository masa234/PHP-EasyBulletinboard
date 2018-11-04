
<!-- ユーザ一覧画面です -->
<?php   

require (  "../setting_func.php" );
require ( get_functions_dir() . "/dbconfig.php" );
require ( get_functions_dir() . "/session.php" );
require ( get_functions_dir() . "/user.php" );

include ( get_views_dir() . "/navbar.php" );

require_authenticate();

$users = user_all();

?>


<div class="container">
    <div class="col-xs-8 col-xs-offset-2">
    <?php foreach ( $users as $user ): ?> 
    <?php require( get_partials_dir() . "/user.php" ); ?>
    <?php endforeach; ?>
    </div>
</div>