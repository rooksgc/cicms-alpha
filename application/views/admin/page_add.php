<? require_once ('modules/header.php'); ?>
<td id="tdmain">

    <div class="settings_div">
        <table class="settings set_page">
            <tbody>
                <tr>
                    <th class="first" colspan="4">
                        Добавление нового раздела
                    </th>
                </tr>
                <tr>
                    <td>
                        Добавляем раздел в
                        <form action="" method="post">
                        <input type="text" value="<?=$title?>" readonly="readonly" style="background-color:#FAFAFA">                        
                    </td>
                    <td>
                        Название
                        <input type="text" name="title" value="<?=set_value ('title')?>">
                    </td>
                    <td>
                        Шаблон
                        <select name="template">
                        <? foreach ($templates as $tpl): ?>
                            <option value="<?=$tpl ['path']?>" <? echo ($tpl ['path'] == 'innerpage')? 'selected' : '' ?>><?=$tpl ['title']?></option>
                        <? endforeach; ?>       
                        </select>                            
                    </td>
                    <td>
                        Показ
                        <div>
                            <input class="cbShowed" type="checkbox" value="1" <?=set_checkbox ('showed', 1, TRUE)?>>
                            <input type="hidden" name="showed" value="<?=set_value ('showed', 1)?>">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>    
                        Title
                        <input type="text" name="head_title" value="<?=set_value ('head_title')?>">
                    </td>
                    <td>
                        Keywords
                        <input type="text" name="head_keywords" value="<?=set_value ('head_keywords')?>">
                    </td>
                    <td>
                        Description
                        <input type="text" name="head_description" value="<?=set_value ('head_description')?>">
                    </td>
                    <td>
                        <input type="hidden" name="parent_id" value="<?=$parent_id?>">
                        <input type="hidden" name="p_path" value="<?=$path?>">
                        <input type="submit" class="formSubmit" value="Добавить раздел">
                        </form>                      
                    </td>
                </tr>
            </tbody>
        </table>
    </div>               
   
</div>
</td>
</body>
</html>