<? require_once ('modules/header.php'); ?>
 
<td id="tdmain">
    <div class="settings_div">
        <table class="settings">
            <tbody>            
            <form action="" method="post">            
                <tr>
                    <th class="first" colspan="3">
                        Название
                    </th>
                    <th>
                        Параметры
                    </th>
                </tr>
                <tr>
                    <td colspan="3">
                        Основной E-mail
                        <div class="sub_helper">Адрес электронной почты, на который будут приходить данные с форм на сайте</div>
                    </td>
                    <td align="center">
                       <input type="text" name="email" value="<?=set_value ('email', $this->config->item ('email'))?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        E-mail отправителя (donotreply)
                        <div class="sub_helper">Адрес электронной почты отправителя, отображаемый в письме</div>
                    </td>
                    <td align="center">
                       <input type="text" name="donotreply_email" value="<?=set_value ('donotreply_email', $this->config->item('donotreply_email'))?>">
                    </td>
                </tr>                
                <tr>
                    <td colspan="3">
                        Список запрещенных URL
                        <div class="sub_helper">Через запятую перечислите список адресов, которые будут запрещены при создании и редактировании страниц</div>
                    </td>
                    <td align="center">
<? $ub = crud::getElements (array('table' => 'settings', 'where' => array('param' => 'url_blacklist'))); $ub = implode (',', unserialize ($ub [0] ['value'])); ?>           
                        <input type="text" name="url_blacklist" value="<?=$ub?>">      
                    </td>
                </tr>                
                <tr>
                    <td colspan="3">
                        Расширенное оповещение
                        <div class="sub_helper">Кроме ошибок валидации показывает изменения в базе, а также статус действий со страницей и модулями - добавление/удаление и т.д.</div>
                    </td>
                    <td align="center">
                        <input type="checkbox" class="cbSettings" value="1" <?=set_checkbox ('extra_info', 1, ($this->config->item ('extra_info') == 1), TRUE)?>>   
                        <input type="hidden" name="extra_info" value="<?=set_value ('extra_info', $this->config->item ('extra_info'))?>">
                    </td>                                     
                </tr>                
                <tr>
                    <td colspan="3">
                        Бенчмарк
                        <div class="sub_helper">Отображение скорости генерации страницы и использования памяти в шапке сайта</div>
                    </td>
                    <td align="center">   
                        <input type="checkbox" class="cbSettings" value="1" <?=set_checkbox ('benchmark', 1, ($this->config->item ('benchmark') == 1), TRUE)?>>   
                        <input type="hidden" name="benchmark" value="<?=set_value ('benchmark', $this->config->item ('benchmark'))?>">
                    </td>                   
                </tr>                 
                <tr>
                    <td colspan="3">
                        Профилирование действий
                        <div class="sub_helper">Отображение действий с базой, переданных/полученных данных из запросов и т.д.</div>    
                    </td>                    
                    <td align="center">   
                        <input type="checkbox" class="cbSettings" value="1" <?=set_checkbox ('profiler', 1, ($this->config->item ('profiler') == 1), TRUE)?>>   
                        <input type="hidden" name="profiler" value="<?=set_value ('profiler', $this->config->item ('profiler'))?>">
                    </td>                    
                </tr>          
                <tr>                
                    <td colspan="4">
                        <input type="submit" class="formSubmit" value="Сохранить настройки">
                    </td>                    
                </tr>                     
            </form>
            </tbody>    
        </table>
    </div>         
</div>

</td>
</body>
</html>  
