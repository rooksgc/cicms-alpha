<?  $faq = crud::getElements (array ('table' => 'faq', 'where' => array ('parent_id' => $module ['id']), 'order' => array ('by' => 'date', 'dir' => 'desc'))); ?> 
<div class="faq clearfix faq<?=$module ['id']?>">
    <h2><?=$module ['title']?></h2>    
<?  if (!empty ($faq)) {
        foreach ($faq as $one) {
            if ($one ['on_site'] != 0) { ?>        
        <div class="faq_container clearfix">
                         
            <div class="faq_question">
              <div class="faq_author"><?=$one ['author']?>,&nbsp;
                <span class="faq_date"><?=mdl_date::newdate ($one ['date'], " ", TRUE)?></span>:
              </div> 
              <div class="faq_question_text"><?=$one ['question']?></div>
            </div>
<? if ($one ['answer'] !== ""): ?>             
            <div class="faq_answer">Ответ:&nbsp;<?=$one ['answer']?></div>
<? endif; ?>                   
        </div>                                       
<? } } } else { echo "Вопросов пока нет. Задайте свой вопрос первым!"; } 
if ($module ['from_site'] == 1) { ?>
    <div class="faq_form clearfix">
        <form class="faq_add">
          <h2>Задайте свой вопрос</h2>
            <input class="faq_input" type="text" name="author" value="Ваше имя" onblur="check_field(this)" onfocus="clear_field(this)">
            <input class="faq_input" type="text" name="email" value="E-mail" onblur="check_field(this)" onfocus="clear_field(this)"> 
            <textarea class="noresize" rows="3" type="text" name="question" onblur="check_field(this)" onfocus="clear_field(this)">Вопрос</textarea>   
            <input class="captcha_code" type="text" name="captchacode" value="Введите код" onblur="check_field(this)" onfocus="clear_field(this)">  
            <img class="captcha" title="Кликните для смены изображения" src="<?='/ajax/captha_img/'.rand (0,999)?>">          
            <div class="update_captcha">изменить</div>                     
            <input type="hidden" name="date" value="<?=date('Y.m.d');?>">
            <input type="hidden" value="<?=$id?>" name="id">
            <input type="hidden" value="<?=$module ['id']?>" name="parent_id">
            <input type="hidden" value="<?=$module ['email']?>" name="email_notice">
            <input type="submit" value="Отправить"> 
        </form>   
    </div>
<? } ?>
    <div id="faq_mes"></div>  
</div>                                           