<!-- Статьи - редактирование | Переменные в таблице ci_articles: id, menu_id, title, text -->
<div id="<?=$number?>" class="module_container_sortable">  
<div class="mod_del">
    <input type="button" class="formSubmit mdel" value="Удалить" data-module="articles" data-id="<?=$id?>" data-moduleid="<?=$module ['id']?>" data-number="<?=$number?>">
</div>
<div class="module_switch">
<? echo ($module ['title'] == "") ? "Статья без названия ID = ".$module ['id']."<span class='mod_title'>Статья</span>" : $module ['title']."<span class='mod_title'>Статья</span>";?>
</div>
 
<div class="module">

<div class="settings_div">
    <table class="settings">
        <tbody>
            <tr>
                <th class="first" colspan="3">
                    Параметры статьи
                </th>
            </tr>
            <tr>
                <td>
                    Заголовок статьи:
                    <form class="article_edit" action="<?=base_url()?>admin/pages/modules" method="post">     
                </td>
                <td>
                    <input type="text" name="title" value="<?=set_value ('title', $module ['title'])?>">    
                </td>
                <td>
                    <input type="submit" class="formSubmit" value="Сохранить изменения">    
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <!--Краткий текст статьи:
                    <textarea name="short_text"><? //=set_value ('short_text', $module ['short_text']);?></textarea><br />-->
                    Текст статьи:
                    <textarea name="text"><?=set_value ('text', $module ['text']);?></textarea>
                    <input type="hidden" value="<?=$id?>" name="id"> 
                    <input type="hidden" value="<?=$module ['id']?>" name="module_id">
                    <input type="hidden" value="articles" name="module">
                    <input type="hidden" value="<?=$number?>" name="number"> 
                    <input type="hidden" value="module_edit" name="task">  
                    </form>  
                </td>
            </tr>
        </tbody>
    </table>
</div>
      
</div>
</div>