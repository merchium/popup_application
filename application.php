<?php

require './init.php';

session_name(SESS_NAME);
session_set_cookie_params(SESSION_ALIVE_TIME, Registry::get('config.current_path'), Registry::get('config.current_host'));
session_start();

if (empty($_SESSION['shop_domain']) && empty($_GET['shop_domain'])) {
    fn_error("Ошибка. Обновите страницу. Если это не поможет, переустановите приложение");

} else if (empty($_SESSION['shop_domain']) && !empty($_GET['shop_domain'])) {
    $merchium = new MerchiumClient(MERCHIUM_APP_KEY, MERCHIUM_CLIENT_SECRET);

    if ($merchium->validateSignature($_GET) != true) {
        fn_error("Error validate signature");

    } else {
        $_SESSION['shop_domain'] = $_GET['shop_domain'];
        fn_redirect('application.php');
    }
}

$shop_domain = $_SESSION['shop_domain'];

$db_conn = db_initiate(Registry::get('config.db_host'), Registry::get('config.db_user'), Registry::get('config.db_password'), Registry::get('config.db_name'));

if (!$db_conn) {
    fn_error("Cannot connect to the database server");
}

if (!empty($_POST['action']) && $_POST['action'] == 'update') {
    db_query("UPDATE ?:data SET ?u WHERE shop_domain = ?s", array('title' => $_POST['data']['title'], 'body' => $_POST['data']['body']), $shop_domain);

    fn_redirect('application.php');
}

$data = db_get_row("SELECT * FROM ?:data WHERE shop_domain = ?s", $shop_domain);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src='https://market.merchium.ru/js/app.js'></script>
<script>
    MerchiumApp.init({
        appKey: '<?php echo MERCHIUM_APP_KEY ?>',
        shopDomain: '<?php echo $shop_domain ?>'
    });

    MerchiumApp.ready(function()
    {
        MerchiumApp.Bar.configure({
            //title: 'New Title',
            buttons: {
                save: {
                    type: 'primary',
                    label: 'Сохранить изменения',
                    callback: function() {
                        document.forms['data_form'].submit();
                    }
                }
            }
        });
    });
</script>
</head>
<body>
    <form name="data_form" class="form-horizontal" action="application.php" method="POST">
        <input type="hidden" name="action" value="update">
        <div class="control-group">
            <h2>Редактирование заголовка и текста баннера</h2>
        </div>
        <div class="control-group">
            <input type="text" name="data[title]" class="input-block-level" id="title" placeholder="Заголовок" value="<?php if (!empty($data['title'])) { echo $data['title']; }?>">
        </div>
        <div class="control-group">
            <textarea name="data[body]" class="input-block-level" id="body" placeholder="HTML-контент" rows="10"><?php if (!empty($data['body'])) { echo $data['body']; }?></textarea>
        </div>
    </form>
</body>
</html>
