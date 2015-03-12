<?php

require './config.php';

define('AREA', 'A');
define('TIME', time());
define('LONG_QUERY_TIME', 3);
define('TABLE_PREFIX', 'popup_app_');
define('DIR_ROOT', dirname(__FILE__));
define('SESS_NAME', 'pop_app_sid');
define('SESSION_ALIVE_TIME', 7200); // 2 hours

mb_internal_encoding('UTF-8');
date_default_timezone_set('Europe/Moscow');

header("P3P: CP=\"Empty P3P policy\"");//IE third party cookie hack

require DIR_ROOT . '/func/mysqli.php';
require DIR_ROOT . '/func/fn.database.php';
require DIR_ROOT . '/func/class.registry.php';
require DIR_ROOT . '/func/MerchiumClient.php';

Registry::set('config', $config);
unset($config);

if (fn_get_ini_param('register_globals')) {
    fn_unregister_globals();
}

//
// Base functions
//
function fn_error($str)
{
    fn_print_die($str);
    exit;
}

function fn_redirect($url)
{
    header("Location: {$url}");
    exit;
}

function fn_print_r()
{
    static $count = 0;
    $args = func_get_args();

    if (!empty($args)) {
        echo '<ol style="font-family: Courier; font-size: 12px; border: 1px solid #dedede; background-color: #efefef; float: left; padding-right: 20px;">';
        foreach ($args as $k => $v) {
            $v = htmlspecialchars(print_r($v, true));
            if ($v == '') {
                $v = '    ';
        }

            echo '<li><pre>' . $v . "\n" . '</pre></li>';
        }
        echo '</ol><div style="clear:left;"></div>';
    }
    $count++;
}

function fn_print_die()
{
    $args = func_get_args();
    call_user_func_array('fn_print_r', $args);
    die();
}

function fn_get_ini_param($param, $get_value = false)
{
    $res = ini_get($param);
    if ($get_value == true) {
        return $res;
    } else {
        return (intval($res) || !strcasecmp($res, 'on')) ? true : false;
    }
}

function fn_unregister_globals($key = NULL)
{
    static $_vars = array('_GET', '_POST', '_FILES', '_ENV', '_COOKIE', '_SERVER');

    $vars = ($key) ? array($key) : $_vars;
    foreach ($vars as $var) {
        if (isset($GLOBALS[$var])) {
            foreach ($GLOBALS[$var] as $k => $v) {
                unset($GLOBALS[$k]);
            }
        }
        if (isset($GLOBALS['HTTP' . $var . '_VARS'])) {
            unset($GLOBALS['HTTP' . $var . '_VARS']);
        }
    }

    return true;
}
