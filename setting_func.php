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
