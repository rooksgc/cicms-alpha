<? // Модель валидации для настроек модулей

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_modules_validate extends CRUD {
    
	// Правила для добавления категории блога
	var $add_category_rules = array (
        array (
			'field' => 'new_category_title',
			'label' => '\'Новая категория\'',
			'rules' => 'trim|required|no_special_symbols|uniq_blog_category[title]',
		)
    );
    
    // Правила для редактирования категории блога    
    var $edit_category_rules = array (    
        array (
			'field' => 'category_title',
			'label' => '\'Категория\'',
			'rules' => 'trim|required|no_special_symbols',
		)    	            	                                      
	);
    
    // Правила для Глобального E-mail для Вопросов-ответов    
    var $faq_global_email_rules = array (    
        array (
			'field' => 'faq_global_email',
			'label' => '\'Общий E-mail для уведомлений\'',
			'rules' => 'trim|no_special_symbols',
		)    	            	                                      
	);	
}
