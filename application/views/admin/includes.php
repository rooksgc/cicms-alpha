<?  require_once ('modules/header.php'); ?>
<td id="tdmain">

    <div class="settings_div">
        <table class="settings">
            <tbody>           
                <tr>
                    <th class="first" colspan="5">
                        Вставки кастомного кода
                    </th>  
                </tr>
                <tr>
                    <td width="10%" align="center">
                        <strong>ID</strong>
                    </td>
                    <td width="30%" align="center">
                        <strong>Название</strong>
                    </td>
                    <td width="30%" align="center">
                        <strong>Код</strong>
                    </td>
                    <td width="30%" colspan="2" align="center">
                        <strong>Операции</strong>
                    </td>                                                            
                </tr>                
<?  
    if (!empty($data)) {
foreach ($data as $include) { ?> 
    <tr>
        <td align="center">
            <?=$include ['id']?>
        </td>
        <td>
            <?=$include ['title']?>
        </td>
                <td>
            <?=$include ['alias']?>
        </td>
        <td width="15%">
            <input data-id="<?=$include ['id']?>" type="button" class="formSubmit include_edit_button" value="Редактировать">
            <div class="include_edit_dialog include_edit_dialog<?=$include ['id']?>" title="Редактирование вставки">
                <form action="<?=base_url()?>admin/includes/include_edit" method="post">
                    <table class="settings dialog_settings">                           
                    <tbody>
                        <tr>
                            <td width="50%">Название<input type="text" name="title" value="<?=$include ['title']?>"></td>
                            <td width="50%">Код<input type="text" name="alias" value="<?=$include ['alias']?>"></td>    
                        </tr>
                        <tr>
                            <td colspan="5">                                        
                                <input type="submit" class="formSubmit" value="Редактировать вставку">
                            </td>
                        </tr>       
                    </tbody>
                    </table>
                    <br />Текст
                    <textarea type="text" name="text"><?=$include ['text']?></textarea>
                    <input type="hidden" name="id" value="<?=$include ['id']?>">
                </form>
            </div>      
        </td>
        <td width="15%">                                
            <input data-id="<?=$include ['id']?>" type="button" class="formSubmit include_del" value="Удалить">
            <div class="cidialog include_del_dialog include_del_dialog<?=$include ['id']?>">
                Удалить вставку '<?=$include ['title']?>' ?
                <form action="<?=base_url()?>admin/includes/include_del" method="post">
                    <input type="hidden" value="<?=$include ['id']?>" name="id">
                    <div class="dialog_buttons">
                        <input type="submit" class="yes" value="ОК">
                        <input type="button" class="no" value="Отмена" onclick="$('.include_del_dialog').dialog('close')">
                    </div>
                </form>   
            </div>            
        </td> 
    </tr>    
<? } } else { ?> 
    <tr>
        <td colspan="4" align="center">
            Вставки отсутствуют
        </td>
    </tr>        
<? } ?>                
                <tr>
                    <td colspan="5">
                    <input type="button" class="formSubmit include_add_button" value="Добавить вставку">
                    <div class="include_add_dialog" title="Добавление вставки">
                        <form action="<?=base_url()?>admin/includes/include_add" method="post">
                            <table class="settings dialog_settings">                           
                            <tbody>
                                <tr>
                                    <td width="50%">Название<input type="text" name="title" value="<?=set_value ('title')?>"></td>
                                    <td width="50%">Код<input type="text" name="alias" value="<?=set_value ('alias')?>"></td>    
                                </tr>
                                <tr>
                                    <td colspan="4">                                        
                                        <input type="submit" class="formSubmit" value="Добавить вставку">
                                    </td>
                                </tr>       
                            </tbody>
                            </table>
                            <br />Текст
                            <textarea type="text" name="text"><?=set_value ('text')?></textarea>
                        </form>
                    </div>  
                    </td>
                </tr>                                            
            </tbody>
        </table>
    </div>                                                     
</td>  
          
</body>
</html>  