<!-- Вопросы-ответы - редактирование -->
<div id="<?=$number?>" class="module_container_sortable">  
<div class="mod_del">
    <input type="button" class="formSubmit mdel" value="Удалить" data-module="faq_list" data-id="<?=$id?>" data-moduleid="<?=$module ['id']?>" data-number="<?=$number?>">
</div>
<div class="module_switch">
<? echo ($module ['title'] == "") ? "Вопросы-ответы без названия ID = ".$module ['id']."<span class='mod_title'>Вопрос-ответ</span>" : $module ['title']."<span class='mod_title'>Вопрос-ответ</span>";?>
</div>
 
<div class="module">

<? $faq = crud::getElements (array ('table' => 'faq', 'where' => array ('parent_id' => $module ['id']))); ?>

<div class="settings_div">
    <table class="settings">
        <tbody>
            <tr>
                <th class="first" colspan="5">
                    Параметры блока вопрос-ответ
                </th>
            </tr>
            <tr>
                <td>
                    Название:<br />
                    <form class="faq_update_params clearfix"> 
                    <input type="text" name="title" value="<?=set_value ('title', $module ['title'])?>">                 
                </td>
                <td>
                    Разрешить вопросы с сайта:
                    <input class="cb_yesno" type="checkbox" value="1" <?=set_checkbox ('from_site', 1, ($module ['from_site'] == 1))?>> 
                    <input type="hidden" name="from_site" value="<?=set_value ('from_site', $module ['from_site'])?>">     
                </td>
                <td>
                    E-mail для уведомлений:<br />
                    <input type="text" name="email" value="<?=set_value ('email', $module ['email'])?>">
                </td>
                <td align="center">
                    <input type="hidden" value="<?=$module ['id']?>" name="module_id"> <!-- ID модуля в базе -->
                    <input type="submit" class="formSubmit" value="Сохранить"> 
                    </form>                    
                </td>
            </tr>
        </tbody>
    </table>
</div>
 
<div id="faq_wrap">

<? if (!empty ($faq)) { ?>

<div class="settings_div">
    <table class="settings">
        <tbody>
            <tr>
                <th class="first nobg" colspan="7">
                    Вопрос-ответ
                </th>
            </tr>
            <tr>
                <td>
                    Автор    
                </td>
                <td>
                    Дата    
                </td>
                <td>
                    E-mail    
                </td>
                <td>
                    Вопрос    
                </td>
                <td>
                    Ответ    
                </td>
                <td>
                    На сайте    
                </td> 
                <td colspan="2"></td>                                                                               
            </tr>
<? foreach ($faq as $one): ?>              
            <tr class="faqblock<?=$one ['id']?>">
                <td>
                    <form class="faq_update_this">
                    <input type="text" name="author" value="<?=$one ['author']?>">    
                </td>
                <td>
                    <input class="datepicker" type="text" name="date" value="<?=mdl_date::newdate ($one ['date'], ".")?>">    
                </td>
                <td>
                    <input type="text" name="email" value="<?=$one ['email']?>">
<? if ($one ['email'] !== "" && $one ['notice'] == 0 && $one ['answer'] !== ""): ?>
                    <input data-faqid="<?=$one ['id']?>" data-email="<?=$one ['email']?>" type="button" class="faq_email_notice faq_notice<?=$one ['id']?>" value="уведомить об ответе">                    
<? endif; ?>    
                    <div class="faq_dialog faq_dialog<?=$one ['id']?>">Отправить уведомление на <?=$one ['email']?>?</div>                
                </td>
                <td>
                    <textarea class="mceNoEditor" id="faq_question" type="text" name="question"><?=$one ['question']?></textarea>    
                </td>
                <td>
                    <textarea class="mceNoEditor" id="faq_answer" type="text" name="answer"><?=$one ['answer']?></textarea>    
                </td>                
                <td align="center">
                    <input class="cb_yesno" type="checkbox" value="1" <?=set_checkbox ('on_site', 1, ($one ['on_site'] == 1))?>>
                    <input type="hidden" name="on_site" value="<?=set_value ('on_site', $one ['on_site'])?>">                  
                </td>
                <td>
                    <input type="hidden" name="id" value="<?=$one ['id']?>">
                    <input type="submit" class="formSubmit" value="Сохранить">
                    </form>      
                </td>
                <td>
                    <input data-faqid="<?=$one ['id']?>" type="button" class="formSubmit faq_del" value="Удалить">
                    <div class="cidialog faq_del_dialog faq_del_dialog<?=$one ['id']?>">
                        Удалить вопрос автора <?=$one ['author']?>?
                        <form action="<?=base_url()?>admin/faq_list/faq_del" method="post">
                            <input type="hidden" value="<?=$id?>" name="id">
                            <input type="hidden" value="<?=$number?>" name="number">
                            <input type="hidden" name="faq_id" value="<?=$one ['id']?>">
                            <div class="dialog_buttons">
                                <input type="submit" class="yes" value="ОК">
                                <input type="button" class="no" value="Отмена" onclick="$('.faq_del_dialog').dialog('close')">
                            </div>
                        </form>
                    </div>   
                </td>                                                                
            </tr>
<? endforeach; ?>                             
        </tbody>
    </table>
</div>

<? } else { echo "Вопросов пока нет <br /><br />"; } ?>

<div class="settings_div" class="clearfix">
    <table class="settings">
        <tbody>
            <tr>
                <th class="first nobg" colspan="4">
                    Новый вопрос
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
                    Вопрос
                </td>
                <td>
                    Ответ
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <form action="<?=base_url()?>admin/faq_list/faq_add" method="post">
                    <input type="text" name="author" value="">
                    <input type="hidden" name="date" value="<?=date("Y.m.d")?>">    
                </td>
                <td>
                    <input type="text" name="email" value="">
                </td>
                <td>                 
                    <textarea class="mceNoEditor" id="faq_question" type="text" name="question" value=""></textarea>    
                </td>
                <td>                 
                    <textarea class="mceNoEditor" id="faq_answer" type="text" name="answer" value=""></textarea>    
                </td>
                <td>
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