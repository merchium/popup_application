<?php

require './init.php';

if (!empty($_GET['code']) && !empty($_GET['shop_domain'])) {
    $shop_domain = $_GET['shop_domain'];
    $merchium = new MerchiumClient(MERCHIUM_APP_KEY, MERCHIUM_CLIENT_SECRET, $shop_domain);

    if ($merchium->validateSignature($_GET) != true) {
        fn_error("Error validate signature");
    }

    //define('MERCHIUM_DEBUG', true);
    $access_token = $merchium->requestAccessToken($_GET['code']);
    if (empty($access_token)) {
        fn_error("Error raised: " . $merchium->getLastError());
    }

    $merchium->setAccessToken($access_token);

    if (!($src_hash = $merchium->createRequest('script_tags', array('src' => 'http://' . Registry::get('config.current_host') . Registry::get('config.current_path') . '/main.js')))) {
        fn_error("Error raised: " . $merchium->getLastError());
    }

    $db_conn = db_initiate(Registry::get('config.db_host'), Registry::get('config.db_user'), Registry::get('config.db_password'), Registry::get('config.db_name'));
    if (!$db_conn) {
        fn_error("Cannot connect to the database server");
    }

    db_query("REPLACE INTO ?:data ?e", array(
        'shop_domain'  => $shop_domain,
        'access_token' => $access_token,
        'title'        => DEFAULT_TITLE,
        'body'         => DEFAULT_BODY,
        'installed_timestamp' => date('Y-m-d H:i:s', TIME)
    ));

    session_name(SESS_NAME);
    session_set_cookie_params(SESSION_ALIVE_TIME, Registry::get('config.current_path'), Registry::get('config.current_host'));  
    session_start();

    $_SESSION['shop_domain'] = $shop_domain;

    fn_redirect('application.php');
}

?>