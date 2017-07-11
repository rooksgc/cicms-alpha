<? // Шаблон внутренней страницы ?>
<div id="breadcrumbs"><?tree::breadcrumbs($menu)?></div>
<div id="content">   
  <div class="inner">
    <h1><?=$title?></h1> 
    <?require_once("modules.tpl")?>    
  </div>   
</div>