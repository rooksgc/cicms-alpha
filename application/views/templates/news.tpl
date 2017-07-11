<? // Шаблон новости ?>
<div id="breadcrumbs"><?tree::breadcrumbs_news($id, $title)?></div>

<div id="content" class="inner">
    <div class="new">
        <h1><?=$title?></h1>  
        <div id="new_wrap" style="padding: 10px">        
            <div class="new_date">Дата: <?=mdl_date::newdate ($date, ".") ?></div>
            <br />
            <div class="new_text"><?=$text?></div>
            <a href="/news" class="news_back"><< назад к списку новостей</a>        
        </div>            
    </div>
    <div class="clearfix"></div>
</div>   