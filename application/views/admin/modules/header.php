<? $CI = &get_instance(); $templates = crud::getElements (array ('table' => 'templates')); $CI->output->enable_profiler (($CI->config->item ('profiler') == 1)? TRUE : FALSE); ?>        
<!DOCTYPE HTML> 
<html>
    <head>
        <meta content="charset=utf-8" http-equiv="Content-Type" />
        <meta name="robots" content="index, follow" />        
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery-ui-1.10.4.min.css" />
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/admin.css" />
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/checkbox.css" />
        <link rel="shortcut icon" href="<?=base_url()?>favicon.ico" />
        <!--[if gt IE 6]><meta content="IE=11" http-equiv="X-UA-Compatible"><![endif]-->
        <script type="text/javascript" src="<?=base_url()?>js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/jquery-ui-1.10.4.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/jquery.ui.datepicker-ru.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/jquery.ui.touch-punch.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/jquery.easing.1.3.js"></script>             
        <script type="text/javascript" src="<?=base_url()?>js/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/tiny_mce/tiny_mce_init.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/checkbox.js"></script>                               
        <script type="text/javascript" src="<?=base_url()?>js/admin.js"></script>       
        <title><?=$page_title?></title>
    </head>
    <body>
<? require_once ('info_message.php'); ?>      
    <table id="admin_table">
        <tbody>
            <tr>
                <td colspan="2">
<? require_once ("menu/menu_top.php"); ?>                
                </td>
            </tr>
            <tr>
                <td id="tdleft"> 
<? require_once ("menu/menu_tree.php"); ?>
                </td>