<!DOCTYPE HTML>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />  
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,600,600italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>    
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/admin.css" /> 
    <link rel="shortcut icon" href="<?=base_url()?>favicon.ico" />
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.10.2.min.js"></script>
    <title><?=$page_title?></title>    
</head>
<body class="login_page">
<? require_once ('admin/modules/info_message.php'); ?>
<div id="login_page">  
    <form action="" method="post">
        <table>
            <tr>
                <td class="auth_input"><label for="login_input">Логин:</label></td>
                <td>
                    <input id="login_input" class="admin_input" type="text" name="login" value="<?=set_value ('login')?>">
                </td>
            </tr>
                <tr>
                <td class="auth_input"><label for="pass_input">Пароль:</label></td>
                <td>
                    <input id="pass_input" class="admin_input" type="password" name="pass" value="">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input id="adm_submit" type="submit" value="Войти">
                </td>
            </tr>   
        </table>
    </form>
</div>
</body>
</html>