<!-- Галерея - редактирование | Переменные в таблице ci_gallery:  id, gallery_id, title, img, sort, alt
                                Переменные в таблице ci_gallery_list:         id, menu_id, title                     -->
<div id="<?=$number?>" class="module_container_sortable">                                         
<? $gal_images = crud::getElements (array ('table' => 'gallery', 'where' => array ('gallery_id' => $module ['id']), 'order' => array ('by' => 'sort', 'dir' => 'ask'))); ?>
<div class="mod_del">
    <input type="button" class="formSubmit mdel" value="Удалить" data-module="gallery_list" data-id="<?=$id?>" data-moduleid="<?=$module ['id']?>" data-number="<?=$number?>">
</div>
<div class="module_switch">
<? echo ($module ['title'] == "") ? "Галерея без названия ID = ".$module ['id']."<span class='mod_title'>Галерея</span>" : $module ['title']."<span class='mod_title'>Галерея</span>";?>
</div>
 
<div class="module">

<div class="settings_div">
    <table class="settings set_gallery">
        <tbody>
            <tr>
                <th class="first" colspan="4">
                    Параметры галереи
                </th>
            </tr>
            <tr>
                <td>
                    <!-- Форма сохранения названия галереи -->
                    Название:
                    <form class="gallery_title_save">    
                </td>
                <td>
                    <input type="text" name="title" value="<?=set_value ('title', $module ['title'])?>">   
                </td>
                <td colspan="2">
                    <input type="hidden" value="<?=$id?>" name="id"> <!-- Передаем id страницы -->
                    <input type="hidden" value="<?=$module ['id']?>" name="module_id"> <!-- ID модуля в базе -->
                    <input type="submit" class="formSubmit" value="Сохранить"> 
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <!-- Форма загрузки файлов -->
                    <form action="<?=base_url()?>admin/gallery_list/gallery_images_add" method="post" enctype="multipart/form-data">
                    <div class="upload_image_input">
                        <span>Добавить изображение</span>
                        <input type="file" name="imgfiles[]" multiple>
                    </div>
                    <span class="upload_image_text"></span>                                      
                </td>
                <td>
                    Тип обрезки изображения:
                    <select name="creation_type">
                        <option value="resize_crop">Обрезать и заполнить</option>
                        <option value="resize">Обрезать и вписать</option>
                    </select>
                </td>
                <td colspan="2">
<? /*Обычная галерея: */ $width = 225;  $height = 140;?>               
                    <input type="hidden" name="width" value="<?=$width?>" readonly="readonly">
                    <input type="hidden" name="height" value="<?=$height?>" readonly="readonly">       
                    <input type="hidden" value="<?=$id?>" name="id"> <!-- Передаем id страницы для возвращения -->
                    <input type="hidden" value="<?=$module ['id']?>" name="module_id"> <!-- ID модуля в базе --> 
                    <input type="hidden" value="<?=$number?>" name="number">                  
                    <input type="submit" class="formSubmit" value="Загрузить">
                    </form>    
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?if ($id == 16) { ?>
<div>Для наилучшего отображения в Слайдере загружайте картинки размером 990 X 380 пикселей</div><br />
<? } ?>
    <!-- Выводим миниатюры изображений -->
    <div class="gal_items_sortable clearfix">
    <? if (!empty ($gal_images)) { 
            foreach ($gal_images as $image) { 
                $ppos = strrpos($image ['img'], '.');
                $mini ['img'] = substr ($image ['img'], 0, $ppos).'_mini.'.substr ($image ['img'], $ppos + 1); ?>
                       
        <div id="<?=$image ['id']?>" class="gal_image_container">
            <div class="gal_image_thumb" style="background: url(<?=base_url()."img/gallery/".$module ['id'].'/'.$mini ['img'] ?>) no-repeat center;"></div>          
           
            <!-- Форма сохранения настроек изображения: img_title, img_alt -->
            <form class="gallery_update_image_params">
                <div class="t_text" title="Title изображения">T:</div><input class="img_title" type="text" name="img_title" value="<?=$image ['img_title']?>">
                <div class="a_text" title="Alt изображения">A:</div><input class="img_alt" type="text" name="img_alt" value="<?=$image ['img_alt']?>">
                <input type="hidden" value="<?=$id?>" name="id"> <!-- Передаем id страницы для возвращения -->
                <input type="hidden" value="<?=$image ['id']?>" name="img_id"> <!-- ID изображения в таблице -->            
                <input class="img_save" type="submit" value="Сохранить">            
            </form>
            <form action="<?=base_url()?>admin/gallery_list/gallery_image_del" method="post">           
                <input type="hidden" value="<?=$id?>" name="id"> <!-- Передаем id страницы для возвращения -->
                <input type="hidden" value="<?=$module ['id']?>" name="module_id"> <!-- ID галереи в базе -->
                <input type="hidden" value="<?=$image ['id']?>" name="img_id"> <!-- ID изображения в таблице -->
                <input type="hidden" value="<?=$image ['img']?>" name="img_name"> <!-- Имя файла -->
                <input type="hidden" value="<?=$number?>" name="number">            
                <input class="img_del" type="submit" value="Удалить" onclick="if(confirm('Вы уверены?'))submit();else return false;">
            </form>   
        </div>
                                 
    <? } } else { echo 'Галерея пуста!';} ?>
    </div>        
</div>
</div>