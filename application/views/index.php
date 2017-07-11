<? $page_title=($head_title !== "")? $head_title : $title.""; ?>
<!DOCTYPE HTML>
<html>
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type" /> 
  <meta name="robots" content="index, follow" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
  <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]--> 
  <meta content="<?=$head_keywords?>" name="keywords" />
  <meta content="<?=$head_description?>" name="description" />
  <title><?=$page_title?></title> 
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,600,600italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>   
  <link rel="stylesheet" type="text/css" charset="utf-8" href="<?=base_url()?>css/style.css" />
  <link rel="stylesheet" type="text/css" charset="utf-8" href="<?=base_url()?>css/jquery.fancybox.css" />
  <link rel="stylesheet" href="<?=base_url()?>css/owl.carousel.css" />
  <link rel="shortcut icon" href="<?=base_url()?>favicon.ico" />       
                                                                           
</head>
<body>                                                                                 
  <header>
    <div id="menu_top">
      <div id="menu_top_wrap">
        <?require_once("templates/modules/menu/menu_main.php");?>    
      </div>
    </div>
  </header> 
    
  <div id="wrap" class="clearfix">      
    <?require_once('templates/'.$template.'.tpl');?> 
  </div> 
    
  <footer>
  </footer>

  <script type="text/javascript" src="<?=base_url()?>js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>js/owl.carousel.min.js"></script>      
  <script type="text/javascript" src="<?=base_url()?>js/jquery.fancybox.pack.js?v=2.1.5"></script>
  <script type="text/javascript" src="<?=base_url()?>js/jquery.mousewheel-3.0.6.pack.js"></script>  
  <script type="text/javascript" src="<?=base_url()?>js/jquery.shadow.js"></script>  
  <script type="text/javascript" src="<?=base_url()?>js/user.js"></script> 
  <script type="text/javascript" src="<?=base_url()?>js/common.js"></script>  
</body>
</html>