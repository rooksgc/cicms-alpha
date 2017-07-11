<?  $start_from = 0;  // Начинаем с первой записи      
    $per_page = $pagination;  // Кол-во записей на странице     
    $all = count ($m_list);  // Всего страниц для навигации
    $num_links = ceil ($all/$per_page);  // Кол-во ссылок < 1 2 3 >
     
if ($all > $per_page ) { 
    $c = 0; $i = 1;
    for ($j = 1; $j <= $num_links; $j++) { ?>
     
<div class="m_group" data-id="<?=$j?>">
<? for ($i = $c + 1; $i <= $per_page + $c; $i++ ) {
    if ($i <= $all) { 
    $module = crud::get_modules ($m_list [$i] ['name'], $m_list [$i] ['module_id']);        
    require ($m_list [$i] ['name'].'/'.$m_list [$i] ['name'].'.php'); 
} } $c = $i - 1; ?>
</div>        

<? } } else {
    foreach ($m_list as $number => $each) :          
    $module = crud::get_modules ($each ['name'], $each ['module_id']);
    require ($each['name'].'/'.$each ['name'].'.php');  
    endforeach;    
} ?> 
<div class="top_paging" style="float:right; display: none;">
    <a id="prev_page" onclick="prev_page();" href="#"><</a>    
    <a id="next_page" onclick="next_page();" href="#">></a>
</div>
<div class="clearfix"></div>       