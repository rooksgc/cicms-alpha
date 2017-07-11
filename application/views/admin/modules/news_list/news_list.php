<!-- Новости - редактирование -->
<div id="<?=$number?>" class="module_container_sortable">  
<div class="mod_del">
    <input type="button" class="formSubmit mdel" value="Удалить" data-module="news_list" data-id="<?=$id?>" data-moduleid="<?=$module ['id']?>" data-number="<?=$number?>">
</div>
<div class="module_switch">
<? echo ($module ['block_title'] == "") ? "Новостная лента без названия ID = ".$module ['id']."<span class='mod_title'>Новостная лента</span>" : $module ['block_title']."<span class='mod_title'>Новостная лента</span>";?>
</div>
 
<div class="module">

<? $news = crud::getElements(array("table"=>"news","where"=>array("parent_id"=>$module["id"]),"order"=>array("by"=>"date","dir"=>"desc")));?>

<div class="settings_div">
    <table class="settings">
        <tbody>
            <tr>
                <th class="first" colspan="5">
                    Параметры новостной ленты
                </th>
            </tr>
            <tr>
                <td>
                    Название ленты:
                    <form class="news_update_params" class="clearfix">                  
                </td>
                <td colspan="3">
                    <input type="text" name="block_title" value="<?=set_value ('block_title', $module ['block_title'])?>">    
                </td>
                <td>
                    <input type="hidden" value="<?=$module ['id']?>" name="module_id">
                    <input type="submit" class="formSubmit" value="Сохранить"> 
                    </form>   
                </td>
            </tr>
        </tbody>
    </table>
</div>
 
<div id="news_wrap">

<? if (!empty ($news)) { ?>

<div class="settings_div">
    <table class="settings">
        <tbody>
            <tr>
                <th class="first nobg" colspan="5">
                    Новости
                </th>
            </tr>
<? foreach ($news as $one): ?>              
            <tr class="news_preview">
                <td width="15%">
                    <?=($one ['author'] !== "")? $one ['author'] : "Автор не указан";?>    
                </td>
                <td width="15%">
<? $newdate = mdl_date::newdate ($one ['date'], "."); echo $newdate; ?>    
                </td> 
                <td>
                    <div class="news_title_preview"><a class="on_news" href="<?=base_url()."news/".$one["path"]?>" target="blank"><?=$one ['title']?></a></div>  
                </td>
                <td width="15%">
                    <input data-id="<?=$one ['id']?>" type="button" class="news_edit_button" value="Редактировать">
                    <div class="news_edit_dialog news_edit_dialog<?=$one ['id']?>" title="Редактировать новость">
                        <form action="<?=base_url()?>admin/news_list/news_update_this" method="post" enctype="multipart/form-data">
                            <table class="settings dialog_settings">                           
                            <tbody>
                                <tr>
                                    <td width="25%">Название<input type="text" name="title" value="<?=$one ['title']?>"></td>
                                    <td width="25%">URL<input type="text" name="path" value="<?=$one ['path']?>"></td>
                                    <td width="25%">Автор<input type="text" name="author" value="<?=$one ['author']?>"></td>
                                    <td width="25%">Дата<input class="datepicker" type="text" name="date" value="<?=$newdate?>"></td>       
                                </tr>
                                <tr>
                                    <td width="25%">Title<input type="text" name="head_title" value="<?=$one ['head_title']?>"></td>
                                    <td width="25%">Keywords<input type="text" name="head_keywords" value="<?=$one ['head_keywords']?>"></td>
                                    <td width="25%">Description<input type="text" name="head_description" value="<?=$one ['head_description']?>"></td>
                                    <td width="25%" align="center">На сайте?<br />
                                        <input class="cb_faq" type="checkbox" value="1" <?=set_checkbox ('on_site', 1, ($one ['on_site'] == 1))?>>
                                        <input type="hidden" name="on_site" value="<?=set_value ('on_site', $one ['on_site'])?>">
                                    </td>   
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        Изображение:<br />
                                        <div class="news_img_wrap">                        
                                            <div class="news_img">
<?  $rnd = rand (0, 255); $news_img = 0; $extension = array ('.jpg', '.jpeg', '.png', '.gif');    
    foreach ($extension as $ext) {
        $n_img = "img/news/mini/".$one["id"].$ext;
        if (is_file ($n_img)) { $news_img++; $nimg = base_url().$n_img; }} 
        if ($news_img !== 0) { ?> <img src="<?=$nimg."?".$rnd;?>" /> <? } else { ?> отсутствует <? } ?>                            
                                            </div> 
                                            <div class="news_img_buttons">
                                                <div class="upload_news_image_input <?=($news_img == 0)? "news_image_input_one" : "";?>">
                                                    <span><?=($news_img !== 0)? "изменить" : "загрузить" ; ?></span>
                                                    <input type="file" name="newsimg">
                                                </div>
                                                <span class="upload_news_image_text"></span>  
<? if ($news_img > 0) { ?>
                                                <input data-id="<?=$one["id"]?>" class="news_img_del" type="button" value="удалить">
                                                <div class="news_img_del_dialog news_img_del_dialog<?=$one["id"]?> cidialog">Удалить изображение?</div>
<? } ?>
                                            </div>
                                        </div>     
                                    </td>
                                    <td colspan="2" align="center">
                                        <a class="on_news" href="<?=base_url()."news/".$one["path"]?>" target="blank">Перейти к новости на сайте >></a>
                                    </td>
                                </tr>   
                                <tr>
                                    <td colspan="4">
                                        <input type="hidden" name="id" value="<?=$id?>">
                                        <input type="hidden" name="number" value="<?=$number?>">
                                        <input type="hidden" name="news_id" value="<?=$one ['id']?>">
                                        <input type="submit" class="formSubmit" value="Редактировать">
                                    </td>
                                </tr>    
                            </tbody>
                            </table>                        
                            <br />Анонс
                            <textarea type="text/html" class="news_edit_announce_textarea" name="announce"><?=$one ['announce']?></textarea>   
                            <br />Текст новости
                            <textarea type="text/html" class="news_edit_text_textarea" name="text"><?=$one ['text']?></textarea>            
                        </form>                    
                    </div> 
                </td>
                <td width="15%">
                    <input data-id="<?=$one ['id']?>" type="button" class="formSubmit news_del" value="Удалить">
                    <div class="cidialog news_del_dialog news_del_dialog<?=$one ['id']?>">
                        Удалить новость '<?=$one ['title']?>' ?
                        <form action="<?=base_url()?>admin/news_list/news_del" method="post">
                            <input type="hidden" value="<?=$id?>" name="id">
                            <input type="hidden" value="<?=$number?>" name="number">
                            <input type="hidden" name="news_id" value="<?=$one ['id']?>">
                            <div class="dialog_buttons">
                                <input type="submit" class="yes" value="ОК">
                                <input type="button" class="no" value="Отмена" onclick="$('.news_del_dialog').dialog('close')">
                            </div>
                        </form>   
                    </div> 
                </td>                                                                               
            </tr>
<? endforeach;?>                                    
        </tbody>
    </table>
</div>
<? } else { echo "Новостей пока нет <br /><br />"; } ?>

<input type="button" class="news_add_button" value="Добавить новость">
<div class="news_add_dialog" title="Добавление новости">
    <form action="<?=base_url()?>admin/news_list/news_add" method="post">
        <table class="settings dialog_settings">                           
        <tbody>
            <tr>
                <td width="25%">Название<input type="text" name="title" value="<?=set_value ('title')?>"></td>
                <td width="25%">URL<input type="text" name="path" value="<?=set_value ('path')?>"></td>
                <td width="25%">Автор<input type="text" name="author" value="<?=set_value ('author')?>"></td>
                <td width="25%">Дата<input class="datepicker" type="text" name="date" value="<?=set_value ('date')?>"></td>       
            </tr>
            <tr>
                <td width="25%">Title<input type="text" name="head_title" value="<?=set_value ('head_title')?>"></td>
                <td width="25%">Keywords<input type="text" name="head_keywords" value="<?=set_value ('head_keywords')?>"></td>
                <td width="25%">Description<input type="text" name="head_description" value="<?=set_value ('head_description')?>"></td>
                <td width="25%" align="center">На сайте?<br />
                    <input class="cb_faq" type="checkbox" value="1" <?=set_checkbox ('on_site', 1, TRUE)?>>
                    <input type="hidden" name="on_site" value="<?=set_value ('on_site', 1)?>">
                </td>   
            </tr>
            <tr>
                <td colspan="4">                                        
                    <input type="hidden" name="id" value="<?=$id?>">
                    <input type="hidden" value="<?=$number?>" name="number">
                    <input type="hidden" value="<?=$module ['id']?>" name="parent_id">
                    <input type="submit" class="formSubmit" value="Добавить">
                </td>
            </tr>       
        </tbody>
        </table>
        <br />Анонс
        <textarea type="text" name="announce"><?=set_value ('announce')?></textarea>  
        <br />Текст новости
        <textarea type="text" name="text"><?=set_value ('text')?></textarea>  
    </form>                    
</div>

</div>
</div>        
</div>