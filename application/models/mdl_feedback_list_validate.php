<? // Модель валидации для отзывов

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_feedback_list_validate extends mdl_feedback_list {

	// Обновление названия отзывов
	var $feedbacks_update_params_rules = array (     
            array (
				'field'	=> 'title',
				'label' => '\'Название\'',
				'rules' => 'trim|no_special_symbols'			
			),
            array (
				'field'	=> 'from_site',
				'label' => '\'Разрешить отправку с сайта\'',
				'rules' => 'numeric'			
			)                      			 	 
	);

    // Добавление / Редактирование отзыва из админки
	var $feedback_update_this_rules = array (   
			array (
				'field'	=> 'author',
				'label' => '\'Автор\'',
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
				'field'	=> 'text',
				'label' => '\'Текст\'',
				'rules' => 'required'			
			),
            array (
				'field'	=> 'on_site',
				'label' => '\'Отображать отзыв на сайте\'',
				'rules' => 'numeric'			
			)                                   			 	 
	);

    // Добавление / Редактирование отзыва с сайта (ajax)
	var $feedback_update_this_rules_ajax = array (   
			array (
				'field'	=> 'author',
				'label' => '\'Автор\'',
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
				'field'	=> 'text',
				'label' => '\'Текст\'',
				'rules' => 'required|no_special_symbols|not[Текст отзыва]'			
			),
            array (
				'field'	=> 'on_site',
				'label' => '\'Отображать отзыв на сайте\'',
				'rules' => 'numeric'			
			)                                   			 	 
	);
    	
}