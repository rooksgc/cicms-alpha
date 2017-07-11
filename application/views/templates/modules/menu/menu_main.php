<?$menu = tree::get_tree ('menu', 1, 2)?> 
 
<div id="menu_main">
    <ul class="level0"><li><a class="<?=($path=='index')?'set':''?>" href="<?=base_url ()?>">Главная</a></li></ul>
    <? tree::menu_main ($menu, 1); ?>          
</div>