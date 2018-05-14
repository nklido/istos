<?php
session_start();

$GLOBALS['config']= array(
    'mysql' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'db'   => 'airbnb-like_schema'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expire' => 604800, // seconds
    ),
    'session' => array(
        'session_name' => 'users'
    )
);

spl_autoload_register(function($class) {
    require_once('classes/'.$class.'.php');
});

require('functions/sanitize.php');
?>
