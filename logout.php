<?php

require_once 'debugSettings.php';
require_once 'DBSessionHandler.php';

$handler = new DBSessionHandler();
session_set_save_handler($handler);
session_start();

$_SESSION = [];
$ses_params = session_get_cookie_params();

setcookie(session_name(), '', time() - 60, $ses_params['path'],
    $ses_params['domain'], $ses_params['secure'], $ses_params['httponly']);

session_destroy();

header("Location: login.php");