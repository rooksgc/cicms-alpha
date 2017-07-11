<!-- Отзывы - редактирование -->
<div id="<?=$number?>" class="module_container_sortable">  
<div class="mod_del">
    <input type="button" class="formSubmit mdel" value="Удалить" data-module="feedback_list" data-id="<?=$id?>" data-moduleid="<?=$module ['id']?>" data-number="<?=$number?>">
</div>
<div class="module_switch">
<? echo ($module ['title'] == "") ? "Отзывы без названия ID = ".$module ['id']."<span class='mod_title'>Отзывы</span>" : $module ['title']."<span class='mod_title'>Отзывы</span>";?>
</div>
 
<div class="module">

<? $feed = crud::getElements (array ('table' => 'feedback', 'where' => array ('parent_id' => $module ['id']), "order"=>array("by"=>"date", "dir"=>"DESC"))); ?>

<div class="settings_div">
    <table class="settings">
        <tbody>
            <tr>
                <th class="first" colspan="5">
                    Параметры блока отзывов
                </th>
            </tr>
            <tr>
                <td>
                    Название:
                    <form class="feedbacks_update_params" class="clearfix">                  
                </td>
                <td>
                    <input type="text" name="title" value="<?=set_value ('title', $module ['title'])?>">    
                </td>
                <td>
                    Разрешить отправку с сайта:
                </td>
                <td align="center">
                    <input class="cb_yesno" type="checkbox" value="1" <?=set_checkbox ('from_site', 1, ($module ['from_site'] == 1))?>> 
                    <input type="hidden" name="from_site" value="<?=set_value ('from_site', $module ['from_site'])?>">                     
                </td>
                <td width="15%">
                    <input type="hidden" value="<?=$module ['id']?>" name="module_id"> <!-- ID модуля в базе -->
                    <input type="submit" class="formSubmit" value="Сохранить"> 
                    </form>   
                </td>
            </tr>
        </tbody>
    </table>
</div>
 
<div id="feedbacks_wrap">

<? if (!empty ($feed)) { ?>

<div class="settings_div">
    <table class="settings">
        <tbody>
            <tr>
                <th class="first nobg" colspan="7">
                    Отзывы
                </th>
            </tr>
<? foreach ($feed as $one): ?>              
            <tr class="feedback_preview">
                <td width="15%">
                    <?=$one ['author']?>    
                </td>
                <td width="15%">
<? $newdate = mdl_date::newdate ($one ['date'], "."); echo $newdate; ?>    
                </td> 
                <td>
                    <div class="feed_text_preview"><?=$one ['text']?></div>  
                </td>
                <td width="15%">
                    <input type="button" class="feedback_edit_button" value="Редактировать" data-feed="<?=$one ['id']?>">
                    <div class="feedback_edit_dialog feedback_edit_dialog<?=$one ['id']?>" title="Редактировать отзыв">
                        <form action="<?=base_url()?>admin/feedback_list/feedback_update_this" method="post">
                            <table class="settings dialog_settings">
                            <tbody>
                                <tr>
                                    <td width="25%">Автор<input type="text" name="author" value="<?=$one ['author']?>"></td>
                                    <td width="25%">Дата<input class="datepicker" type="text" name="date" value="<?=$newdate?>"></td>
                                    <td width="25%">E-mail<input type="text" name="email" value="<?=$one ['email']?>"></td>
                                    <td width="25%" align="center">На сайте?<br /><input class="cb_yesno" type="checkbox" value="1" <?=set_checkbox ('on_site', 1, ($one ['on_site'] == 1))?>>
                            <input type="hidden" name="on_site" value="<?=set_value ('on_site', $one ['on_site'])?>"></td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <input type="hidden" name="id" value="<?=$id?>">
                                        <input type="hidden" name="feedback_id" value="<?=$one ['id']?>">
                                        <input type="hidden" value="<?=$number?>" name="number">
                                        <input type="submit" class="formSubmit" value="Сохранить"> 
                                    </td>   
                                </tr>
                            </tbody>
                            </table>
                            <br />
                            <textarea type="text" name="text"><?=$one ['text']?></textarea>
                        </form>                    
                    </div>
                </td>
                <td width="15%">
                    <input data-id="<?=$one ['id']?>" type="button" class="formSubmit feed_del" value="Удалить">
                    <div class="cidialog feed_del_dialog feed_del_dialog<?=$one ['id']?>">
                        Удалить отзыв автора <?=$one ['author']?>?
                        <form action="<?=base_url()?>admin/feedback_list/feedback_del" method="post">
                            <input type="hidden" value="<?=$id?>" name="id">
                            <input type="hidden" value="<?=$number?>" name="number">
                            <input type="hidden" name="feedback_id" value="<?=$one ['id']?>">
                            <div class="dialog_buttons">
                                <input type="submit" class="yes" value="ОК">
                                <input type="button" class="no" value="Отмена" onclick="$('.feed_del_dialog').dialog('close')">
                            </div>
                        </form>   
                    </div> 
                </td>                                                                               
            </tr>  
<? endforeach; ?>             
        </tbody>
    </table>
</div>

<? } else { echo "Отзывов пока нет <br />"; } ?>

<div class="settings_div" class="clearfix">
    <table class="settings">
        <tbody>
            <tr>
                <th class="first nobg" colspan="4">
                    Новый отзыв
                </th>
            </tr>
            <tr>
                <td>
                    Автор
                </td>
                <td>
                    E-mail
                </td>
                <td>
                    Текст
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <form action="<?=base_url()?>admin/feedback_list/feedback_add" method="post">
                    <input type="text" name="author" value="">
                    <input type="hidden" name="date" value="<?=date("Y.m.d")?>">    
                </td>
                <td>
                    <input type="text" name="email" value="">
                </td>
                <td>                 
                    <textarea class="mceNoEditor feed_text" type="text" name="text" value=""></textarea>    
                </td>
                <td width="15%">
                    <input type="hidden" value="<?=$id?>" name="id">
                    <input type="hidden" value="<?=$number?>" name="number">
                    <input type="hidden" name="parent_id" value="<?=$module ['id']?>">
                    <input type="submit" class="formSubmit" value="Добавить"> 
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</div>
</div>        
</div>