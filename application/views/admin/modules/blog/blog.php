<!-- Блог - редактирование | Переменные в таблице ci_blog: id, menu_id, category_id, date, title, preview, text, author, head_title, head_keywords, head_description -->
<div id="<?=$number?>" class="module_container_sortable">  
<? $blog_categories = crud::getElements (array ('table' => 'blog_categories', 'order' => array ('by' => 'id', 'dir' => 'ask'))); ?>
<div class="mod_del">
    <input type="button" class="formSubmit mdel" value="Удалить" data-module="blog" data-id="<?=$id?>" data-moduleid="<?=$module ['id']?>" data-number="<?=$number?>">
</div>

<div class="module_switch"><? if ($module ['title'] == "") {echo "Запись без названия ID = ".$module ['id']."<span class='mod_title'>Запись блога</span>";} else { echo $module ['title']."<span class='mod_title'>Запись блога</span>";} ?></div>
<div class="module">

<div class="settings_div">
    <table class="settings">
        <tbody>
            <tr>
                <th class="first" colspan="4">
                    Параметры записи блога
                </th>
            </tr>
            <tr>
                <td>
                    Заголовок записи
                    <form action="<?=base_url()?>admin/pages/modules" method="post">
                    <input type="text" value="<?=set_value ('title', $module ['title'])?>" name="title">    
                </td>
                <td>
                    URL
                    <input type="text" value="<?=set_value ('path', $module ['path'])?>" name="path">
                </td>
                <td>
                    Дата
<? $newdate = ($module ['date'] == null)? date ("d.m.Y") : mdl_date::newdate ($module ['date'], ".") ?>                                        
                    <input class="datepicker" type="text" value="<?=set_value ('date', $newdate)?>" name="date">    
                </td>
                <td>
                    Автор
                    <input type="text" value="<?=set_value ('author', $module ['author'])?>" name="author">    
                </td>
            </tr>
            <tr>            
                <td>
                    Title
                    <input type="text" name="head_title" value="<?=set_value ('head_title', $module ['head_title'])?>">    
                </td>
                <td>
                    Keywords
                    <input type="text" name="head_keywords" value="<?=set_value ('head_keywords', $module ['head_keywords'])?>">    
                </td>
                <td>
                    Description
                    <input type="text" name="head_description" value="<?=set_value ('head_description', $module ['head_description'])?>">    
                </td>
                <td>
                    Категория
                    <select name="category_id">
<? foreach ($blog_categories as $category): ?>
                        <option value="<?=$category ['id']?>" 
<?=($category ['id'] == $module ['category_id'])? "selected=\"selected\"" : ""; ?>><?=$category ['title']?>
                        </option>         
<?endforeach;?>
                    </select>                        
                </td>                    
            </tr>
            <tr>
                <td colspan="4">
                    <a class="on_page" target="blank" href="<?=base_url().'blog/'.$module ['path']?>">Перейти к записи >></a>    
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <input type="submit" class="formSubmit" value="Редактировать запись">
                </td>
            </tr>
            <tr>
                <td align="center" colspan="4">
                <input class="bt_show" type="button" value="Показать анонс и текст">
                <div class="blog_texts">    
                    Анонс<div class="br"></div>
                    <textarea name="preview"><?=set_value ('preview', $module ['preview'])?></textarea><br /> 
                    Текст записи
                    <textarea name="text"><?=set_value ('text', $module ['text'])?></textarea>
                    <div class="br"></div>
                    <input type="hidden" value="<?=$id?>" name="id"> <!-- Передаем id страницы для возвращения -->
                    <input type="hidden" value="<?=$module ['id']?>" name="module_id"> <!-- ID модуля в базе -->
                    <input type="hidden" value="<?=$number?>" name="number"> <!-- Номер индекса массива -->
                    <input type="hidden" value="blog" name="module">
                    <input type="hidden" value="module_edit" name="task">
                    </form> 
                </div>   
                </td>
            </tr>
        </tbody>
    </table>
</div>
 
</div>
</div>