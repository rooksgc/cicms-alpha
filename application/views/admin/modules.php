<? $CI = &get_instance (); require_once ('modules/header.php'); ?>
<td id="tdmain">

    <div class="settings_div">
        <table class="settings">
            <tbody>           
                <tr>
                    <th class="first" colspan="5">
                        Настройки модулей
                    </th>  
                </tr>
                <tr>
                    <td align="center" colspan="5">
                        <strong>Вопрос-ответ</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">                             
                        Общий E-mail для уведомлений
                        <div class="sub_helper">Адрес электронной почты, на который будут приходить уведомления о наличии новых вопросов с сайта. Уведомление на этот адрес поступит только в том случае, если соответствующее поле для каждого конкретного блока вопрос-ответ останется пустым.</div>
                        <form action="<?=base_url ()."admin/modules/faq_global_email_update"?>" method="post">  
                    </td>
                    <td>
                        <input type="text" name="faq_global_email" value="<?=$CI->config->item ('faq_global_email')?>">    
                    </td>
                    <td colspan="2">
                        <input type="submit" value="Сохранить">
                        </form>    
                    </td>
                </tr>                             
                <tr>
                    <td align="center" colspan="5">
                        <strong>Блог</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        Новая категория
                        <div class="sub_helper">Добавьте новую категорию для блога и она станет доступной для выбора в каждой из записей</div>
                    </td>
                    <td>
                        <form action="<?=base_url ()."admin/modules/blog_category_add"?>" method="post">
                        <input type="text" name="new_category_title" value="">
                    </td>
                    <td colspan="2">
                        <input type="submit" value="Добавить">
                        </form>
                    </td>
                </tr>
                <tr>
<? $blog_categories = crud::getElements (array ('table' => 'blog_categories', 'order' => array ('by' => 'id', 'dir' => 'ask')));
    if (!empty ($blog_categories)) { 
        foreach ($blog_categories as $category): ?>                
                    <td colspan="2">
                        Список существующих категорий
                        <div class="sub_helper">Категории блога, которые уже добавлены</div>                    
                    </td>
 
                    <td>
                        <form action="<?=base_url ()."admin/modules/blog_category_edit"?>" method="post">
                            <input type="text" name="category_title" value="<?=set_value ('category_title', $category ['title'])?>">                    
                    </td>                    
                    <td>
                            <input type="hidden" value="<?=$category ['id']?>" name="id">    
                            <input type="submit" value="Редактировать">
                        </form>                    
                    </td>
                    <td>
                        <input data-blogcatid="<?=$category ['id']?>" type="button" class="formSubmit blogcat_del" value="Удалить">
                        <div class="cidialog blog_cat_del_dialog blog_cat_del_dialog<?=$category ['id']?>">
                            Удалить категорию блога<br />"<?=$category ['title']?>"?
                            <form action="<?=base_url ()."admin/modules/blog_category_delete"?>" method="post">
                                <input type="hidden" name="category_title" value="<?=$category ['title']?>">
                                <input type="hidden" value="<?=$category ['id']?>" name="id">  
                                <div class="dialog_buttons">
                                    <input type="submit" class="yes" value="ОК">
                                    <input type="button" class="no" value="Отмена" onclick="$('.blog_cat_del_dialog').dialog('close')">
                                </div>                
                            </form>
                        </div> 
                    </td> 
<? endforeach; } else { ?>
                    <td colspan="5" align="center">
                        В списке нет ни одной категории   
                    </td>
<? } ?>                     
                </tr> 
                <tr>
                    <td align="center" colspan="5">
                        <strong>Капча</strong>  
<?  $captcha = unserialize ($CI->config->item ('captcha_info')); ?>   
                    </td>
                </tr>
                <tr>                     
                    <td width="20%">
                        Цвет текста   
                        <form action="<?=base_url ()."admin/modules/captcha_params_save"?>" method="post">
                        <select name="color">
                            <option style="color:green" value="green" <?=($captcha['color']=='green')?"selected":"";?>>зеленый</option>
                            <option style="color:red" value="red" <?=($captcha['color']=='red')?"selected":"";?>>красный</option>
                            <option style="color:blue" value="blue" <?=($captcha['color']=='blue')?"selected":"";?>>голубой</option>
                            <option style="color:black" value="black" <?=($captcha['color']=='black')?"selected":"";?>>черный</option>
                            <option style="color:grey" value="white" <?=($captcha['color']=='white')?"selected":"";?>>белый</option>
                        </select>                        
                    </td>
                    <td width="20%">
                        Ширина рисунка<br /> 100 px <!--<input type="text" name="width" value="<?=$captcha ['width']?>">-->
                    </td>
                    <td width="20%">
                        Высота рисунка<br /> 50 px <!--<input type="text" name="height" value="<?=$captcha ['height']?>">-->
                    </td>
                    <td width="20%">
                        Кол-во символов
                        <select name="symbols">
                            <option value="3" <?=($captcha['symbols']=='3')?"selected":"";?>>три</option>
                            <option value="4" <?=($captcha['symbols']=='4')?"selected":"";?>>четрые</option>
                            <option value="5" <?=($captcha['symbols']=='5')?"selected":"";?>>пять</option>
                            <option value="6" <?=($captcha['symbols']=='6')?"selected":"";?>>шесть</option>
                        </select>    
                    </td>
                    <td width="20%">
                        <input type="submit" class="formSubmit" value="Сохранить">
                        </form>    
                    </td>                                                
                </tr>                                             
            </tbody>
        </table>
    </div>                
                                     
</td>            
</body>
</html>  