<? $blog_categories = crud::getElements (array ('table' => 'blog_categories', 'where' => array ('id' => $module ['category_id']))); ?>  
<div class="blog_record_show clearfix">
    <h2><a href="<?=base_url()?>blog/<?=$module ['path']?>"><?=$module ['title']?></a></h2>
    <div id="blog_author_date_cat"><?=($module ['date'] !== NULL)? mdl_date::newdate ($module ['date'], ".") : "";?>    
     | Автор: <?=$module ['author']?> | Категория: 
<? echo (!empty ($blog_categories))? $blog_categories [0] ['title'] : "без категории";?>
    </div>
    <div id="blog_preview"><?=$module ['preview']?></div>
    <br />
    <? if ($module['text'] !== "") { ?>
    <div id="blog_record_show_link"><a href="<?=base_url()?>blog/<?=$module ['path']?>">Читать далее >></a></div>
    <? } ?>
</div>  