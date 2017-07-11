<? $feedback = crud::getElements (array ('table' => 'feedback', 'where' => array ('parent_id' => $module ['id']), 'order' => array ('by' => 'date', 'dir' => 'desc'))); ?> 
<div class="feedback clearfix feed<?=$module ['id']?>">
    <h2><?=$module ['title']?></h2>    
<?  if (!empty ($feedback)) {
        foreach ($feedback as $one) {
            if ($one ['on_site'] != 0) { ?>        
        <div class="feedback_container">
            <div class="feedback_author"><span>Автор:&nbsp;</span><?=$one ['author']?>&nbsp;|&nbsp;Дата:&nbsp;<span class="feedback_date"><?=$one ['date']?></span></div>              
            <div class="feedback_text"><?=$one ['text']?></div>        
        </div>                                       
<? } } } else { echo "Пока нет ни одного отзыва."; } 
if ($module ['from_site'] == 1) { ?>
    <div class="feedback_form clearfix">
        <form class="feedback_add">
            <h2>Оставьте свой отзыв</h2> 
            <input class="feedback_input" type="text" name="author" value="Ваше имя" onblur="check_field(this)" onfocus="clear_field(this)">
            <input class="feedback_input" type="text" name="email" value="E-mail" onblur="check_field(this)" onfocus="clear_field(this)"> 
            <textarea class="noresize" rows="3" type="text" name="text" onblur="check_field(this)" onfocus="clear_field(this)">Текст отзыва</textarea>   
            <input class="captcha_code" type="text" name="captchacode" value="Введите код" onblur="check_field(this)" onfocus="clear_field(this)">  
            <img class="captcha" title="Кликните для смены изображения" src="<?='/ajax/captha_img/'.rand (0,999)?>">          
            <div class="update_captcha">изменить</div>                     
            <input type="hidden" name="date" value="<?=date('Y.m.d');?>">
            <input type="hidden" value="<?=$id?>" name="id">
            <input type="hidden" value="<?=$module ['id']?>" name="parent_id">
            <input type="hidden" value="1" name="is_ajax">
            <input type="submit" value="Отправить"> 
        </form>   
    </div>
<? } ?>
    <div id="feedback_mes"></div>  
</div>                                           