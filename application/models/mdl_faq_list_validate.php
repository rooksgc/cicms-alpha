<? // Модель валидации для отзывов

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_faq_list_validate extends mdl_faq_list {

	// Обновление названия вопросов-ответов
	var $faq_update_params_rules = array (     
            array (
				'field'	=> 'title',
				'label' => '\'Название\'',
				'rules' => 'trim|no_special_symbols'			
			),
            array (
				'field'	=> 'email',
				'label' => '\'E-mail для уведомлений\'',
				'rules' => 'trim|no_special_symbols'			
			),            
            array (
				'field'	=> 'from_site',
				'label' => '\'Разрешить вопрос с сайта\'',
				'rules' => 'numeric'			
			)                      			 	 
	);
    
    // Добавление / Редактирование вопросов-ответов
	var $faq_update_this_rules = array (   
			array (
				'field'	=> 'author',
				'label' => '\'Ваше имя\'',
				'rules' => 'trim|required|no_special_symbols|not[Ваше имя]'			
			),
            array (
				'field'	=> 'email',
				'label' => '\'E-mail\'',
				'rules' => 'trim|no_special_symbols'			
			),
            array (
				'field'	=> 'date',
				'label' => '\'Дата\'',				
                'rules' => 'no_special_symbols'			
			),
            array (
				'field'	=> 'question',
				'label' => '\'Вопрос\'',
				'rules' => 'required|no_special_symbols|not[Вопрос]'			
			),
            array (
				'field'	=> 'answer',
				'label' => '\'Ответ\'',
				'rules' => 'no_special_symbols|not[Ответ]'			
			),            
            array (
				'field'	=> 'on_site',
				'label' => '\'Отображать вопрос-ответ на сайте\'',
				'rules' => 'numeric'			
			)                                   			 	 
	);
    	
}