<!DOCTYPE html>
<html>
<head>
    <meta content="text/html" http-equiv="Content-Type">
    <meta content="<?=$head_keywords?>" name="keywords">
    <meta content="<?=$head_description?>" name="description">
    <title><?=$head_title?></title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/jquery.fancybox.css">
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.mousewheel-3.0.6.pack.js"></script> 
    <script type="text/javascript" src="<?=base_url()?>js/user.js"></script>
</head>
<body>
    <div id="wrap">     
        <header>
        
<? $menu = tree::get_tree ('menu', 1, 2); ?> 
<div id="menu_main">
    <ul class="level0"><li><a class="<?=($menu_id==1)?'set':''?>" href="<?=base_url()?>">Главная</a></li></ul>
    <? tree::menu_main ($menu, 1, 1); ?>          
</div> 

            <? if ($this->config->item ('benchmark') == 1) { ?> <div style="position:absolute;top:0;right:9px;color:grey;font-size:9px;padding:3px;">время генерации страницы: <?=$this->benchmark->elapsed_time ();?><br />использование памяти: <?=$this->benchmark->memory_usage ();?></div> <? } ?>             
        </header> 
        <div id="content">
            <div class="blog_record">
                <!-- Запись блога -->
<? $blog_categories = crud::getElements (array ('table' => 'blog_categories', 'where' => array ('id' => $category_id))); ?>                
                <h1><?=$title?></h1>
                <div id="blog_author_date_cat"><?=mdl_date::newdate ($date, ".") ?> | Автор: <?=$author?> | Категория: 
<? echo (!empty ($blog_categories))? $blog_categories [0] ['title'] : "без категории";?>
                </div>
                <div id="blog_text"><?=$text?></div>
                <a id="blog_back_link" href="javascript:history.back();"> << Назад к списку записей</a>            
            </div>
        </div>
        <footer>                                                        
        </footer>
    </div>   
</body>
</html>