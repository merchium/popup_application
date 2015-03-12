<?php

//
// Config
//

$config = array();
$config['db_host'] = '';
$config['db_name'] = '';
$config['db_user'] = '';
$config['db_password'] = '';
$config['db_type'] = 'mysqli';

$config['current_host'] = 'example.com';
$config['current_path'] = '/popup_application';
//note! also edit host and path in main.js

define('MERCHIUM_APP_KEY', '');
define('MERCHIUM_CLIENT_SECRET', '');

define('DEFAULT_TITLE', 'Заголовок');
define('DEFAULT_BODY',  '<strong>Содержимое</strong>');

error_reporting(E_ALL);
