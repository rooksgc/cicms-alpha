<? require_once ('modules/header.php'); ?>
<td id="tdmain">

    <div class="settings_div">
        <table class="settings set_page">
            <tbody>            
                <tr>
                    <th class="first" colspan="4">
                        Параметры раздела
                    </th>
                </tr>
                <tr>
                    <td>
                        Редактируем раздел:
                        <form action="<?=base_url ().'admin/pages/page_edit/'.$id?>" method="post" enctype="multipart/form-data">
                    </td>
                    
                    <td>
                        <input type="text" name="title" value="<?=set_value ('title', $title)?>">
                    </td>
                    <td>
                        URL:
<? $p_path = explode ("/", $path); $last = array_pop ($p_path); $p_path = implode ("/", $p_path); ?> 
<?=($level > 1)? "<input class='pre_url' value='$p_path/' readonly='readonly'>":"";?>     
                    </td>
                    <td>                        
                        <input type="text" name="path" value="<?=set_value ('path', $last)?>"<?=($path=="index")?"readonly='readonly'":"";?>>
                    </td>    
                </tr>
                <tr>
                    <td>
                        Изображение:<br />
                        <div class="page_img_wrap">                        
                            <div class="page_img">
<?  $rnd = rand (0, 255); $page_img = 0; $extension = array ('.jpg', '.jpeg', '.png', '.gif');    
    foreach ($extension as $ext) {
        $p_img = "img/page/mini/".$id.$ext;
        if (is_file ($p_img)) { $page_img++; $img = base_url().$p_img; }} 
    if ($page_img !== 0) { ?> <img src="<?=$img."?".$rnd;?>" /> <? } else { ?> отсутствует <? } ?>                            
                            </div> 
                            <div class="page_img_buttons">
                                <div class="upload_image_input <?=($page_img == 0)? "upload_image_one" : "";?>">
                                    <span><?=($page_img !== 0)? "изменить" : "загрузить" ; ?></span>
                                    <input type="file" name="pageimg">
                                </div>
                                <span class="upload_image_text"></span>  
<? if ($page_img > 0) { ?>
                                <input class="page_img_del" type="button" value="удалить">
                                <div data-id="<?=$id?>" class="page_img_del_dialog cidialog">Удалить изображение?</div>
<? } ?>
                            </div>
                        </div>     
                    </td>                    
                    <td>
                        Шаблон:<br />
                        <select name="template">
                        <? foreach ($templates as $tpl): ?>
                            <option value="<?=$tpl ['path']?>" <? echo ($tpl ['path'] == $template ? "selected" : '');?>><?=$tpl ['title']?></option>
                        <? endforeach; ?>        
                        </select>
                    </td> 
                    <td>
                        Пейджинг (0 - откл.):<br />
                        <input type="text" name="pagination" value="<?=set_value ('pagination', $pagination)?>">
                    </td>
                    <td>
                        Показ
                        <br />
                        <input class="cbShowed" type="checkbox" value="1" <?=set_checkbox ('showed',1,($showed == 1), TRUE)?>>
                        <input type="hidden" name="showed" value="<?=set_value ('showed', $showed)?>">
                        <br />
                        В меню
                        <br />
                        <input class="cb_yesno" type="checkbox" value="1" <?=set_checkbox ('in_menu',1,($in_menu == 1), TRUE)?>>
                        <input type="hidden" name="in_menu" value="<?=set_value ('in_menu', $in_menu)?>">
                        <br />
                        На главной
                        <br />
                        <input class="cb_yesno" type="checkbox" value="1" <?=set_checkbox ('on_main',1,($on_main == 1), TRUE)?>>
                        <input type="hidden" name="on_main" value="<?=set_value ('on_main', $on_main)?>">                                            
                    </td> 
                </tr>
                <tr>
                    <td>
                        Title
                        <input type="text" name="head_title" value="<?=set_value ('head_title', $head_title)?>">
                    </td>
                    <td>
                        Keywords
                        <input type="text" name="head_keywords" value="<?=set_value ('head_keywords', $head_keywords)?>">
                    </td>
                    <td>
                        Description
                        <input  type="text" name="head_description" value="<?=set_value ('head_description', $head_description)?>">
                    </td>
                    <td>
                        <a class="on_page" target="blank" href="<?=base_url ($path)?>">В раздел на сайте >></a>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <input type="hidden" name="p_path" value="<?=$p_path?>">  
                        <input type="hidden" name="id" value="<?=$id?>">
                        <input type="submit" class="formSubmit" value="Редактировать раздел">
                        </form> 
                    </td>
                </tr>                                             
            </tbody>
        </table>
    </div>
                                                                  
<!-- Выводим подключенные модули -->
<div class="modules_sortable">               
<?  if ($modules !== null) { $modules_list = unserialize ($modules);   
    if (!empty ($modules_list)) { ?>
    <div id="sort_switch" class="sort_off">сортировка отключена</div><div id="modules_uncover" class="modules_hidden">развернуть все блоки</div><br><br><div style="clear:both"></div> 
<?  foreach ($modules_list as $number => $each) {
    if (!isset ($last_key)) {$last_key = $number;} 
    $module = crud::get_modules ($each ['name'], $each ['module_id']);
    require ('modules/'.$each ['name'].'/'.$each ['name'].'.php');
    if ($number > $last_key) {$last_key = $number;} } } }
?>
</div>

<? require_once ('modules/dialogs.php'); ?>
 
<div id="mod_blocks">
<?  $allmods = array (
        "articles" => "Статья",
        "blog" => "Запись блога",
        "gallery_list" => "Галерея",
        "feedback_list" => "Отзывы",
        "faq_list" => "Вопрос-ответ",
        "news_list" => "Новостная лента"
); 
    foreach ($allmods as $mname => $mtitle):
?>                                  
    <form id="modules_add" action="<?=base_url()?>admin/pages/modules" method="post">
        <input type="hidden" value="<?=$id?>" name="id">
        <input type="hidden" value="<?=$mname?>" name="module">
        <input type="hidden" value="module_add" name="task">
        <input type="submit" value="<?=$mtitle?>">     
    </form> 
<? endforeach; ?>   
</div>    
            </div>     
        </td>    
    </body>
</html>