<?php

require './init.php';

if (empty($_GET['shop_domain']) || empty($_GET['callback'])) {
    die();
}

$db_conn = db_initiate(Registry::get('config.db_host'), Registry::get('config.db_user'), Registry::get('config.db_password'), Registry::get('config.db_name'));

if ($db_conn) {
    $data = db_get_row("SELECT title, body FROM ?:data WHERE shop_domain = ?s", trim($_GET['shop_domain']));

    echo "{$_GET['callback']}(". json_encode($data) . ")";
}