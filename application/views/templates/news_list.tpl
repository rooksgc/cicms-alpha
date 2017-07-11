<? // Шаблон списка новостей ?>
<div id="breadcrumbs"><? tree::breadcrumbs($menu)?></div>

<div id="content" class="inner">
    <h1><?=$title?></h1>          
<?
$news = crud::getElements(array("table"=>"news","where"=>array("on_site"=>1),"order"=>array("by"=>"date","dir"=>"desc"))); 
if (count($news) > 0) {
?>
<div id="news">
<? 
for($i = 0; $i < count($news); $i++) {
if ($news[$i]["on_site"] != 0) {
$rnd = rand (0, 255); $news_img = 0; $extension = array('.jpg', '.jpeg', '.png', '.gif');
$default = "img/news/default.jpg";  
foreach ($extension as $ext) { 
    $n_img = "img/news/".$news[$i]["id"].$ext;
    if (is_file($n_img)) { $news_img++; $img = $n_img; }
}
?>
    <div class="new">
        <a href="<?="news/".$news[$i]["path"]?>">
            <div class="new_pic" style="background:url(<?=($news_img !== 0)? $img.'?'.$rnd : $default;?>)"></div>
            <span class="new_cap"><?=$news[$i]["title"]?></span>
        </a>     
    </div>
<? } } ?>        
</div>
<? } ?> 
     
<div class="clearfix"></div>
</div> 