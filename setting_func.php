<?php

function get_functions_dir(){
    return dirname( __FILE__ ) . '/functions';
}

function get_views_dir(){
    return dirname( __FILE__ ) . '/views';
}

function get_partials_dir(){
    return get_views_dir() . '/partials';
}

function h( $str ) {
    return htmlspecialchars( $str, ENT_QUOTES, 'UTF-8');
}
