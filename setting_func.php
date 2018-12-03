<?php 

function get_require_dir(){
    return dirname( __FILE__ ) . '/require';
}

function get_views_dir(){
    return dirname( __FILE__ ) . '/views';
}

function get_partials_dir(){
    return get_views_dir() . '/partials';
}

require ( get_require_dir() . "/dbconfig.php" );
require ( get_require_dir() . "/common.php" );
require ( get_require_dir() . "/session.php" );
require ( get_require_dir() . "/navbar.php" );