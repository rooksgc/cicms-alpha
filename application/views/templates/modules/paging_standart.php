<?  $CI = &get_instance();
if ($path == "index") {$level = 1;}
$per_page = $pagination;  // Кол-во записей на странице     
$all = count ($m_list);  // Всего страниц для навигации
$num_links = ceil ($all/$per_page);  // Кол-во ссылок < 1 2 3 >
$seg = $this->uri->segment ($level+1, 0); // Достаем сегмент с цифрой начальной страницы
$segment = (!$seg)? 1 : $seg; 
$start_from = ($segment !== "")? $segment * $per_page - $per_page : 0;                
$prev = $segment - 1; if ($prev < 1) {$prev = 1;}
$next = $segment + 1; if ($next > $num_links) {$next = $segment;}
$pages = array_slice ($m_list, $start_from, $per_page /*$preserve_keys = true*/);

if ($all > $per_page) { ?>                                              
<div class="top_paging clearfix">
    <a id="p_page" href="<?=($path == 'index')? base_url().'index/'.$prev : base_url().$path.'/'.$prev; ?>"><</a>
<?  for ($i = 0; $i < $num_links; $i++): $j = $i + 1;  
echo ($segment==$j)?'<span':'<a';?> class='p_link<?=($segment==$j)?' set':'';?>' href="<?=($path=='index')? base_url().'index/'.$j : base_url().$path.'/'.$j;?>"><?=$j?><<?=($segment==$j)?'/span':'/a';?>>             
<?  endfor; ?>    
    <a id="n_page" href="<?=($path == 'index')? base_url().'index/'.$next : base_url().$path.'/'.$next; ?>">></a>
</div>
<? }
 
for ($i = 0; $i < $per_page; $i++ ) {
    if ($i < count ($pages)) {   
        $module = crud::get_modules ($pages [$i] ['name'], $pages [$i] ['module_id']);        
        require ($pages [$i] ['name'].'/'.$pages [$i] ['name'].'.php');            
    } 
} ?>