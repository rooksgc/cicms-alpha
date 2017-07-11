<? // Модель валидации для статей

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_articles_validate extends CRUD {
		
	//Правила валидации для добавления страницы
	var $edit_articles_rules = array (
			array (
				'field'	=> 'title',
				'label' => '\'Заголовок статьи\'',
				'rules' => 'trim|no_special_symbols'			
			),  
            array (
				'field'	=> 'short_text',
				'label' => '\'Краткий текст\'',
				'rules' => ''			
			),    
            array (
				'field'	=> 'text',
				'label' => '\'Текст статьи\'',
				'rules' => ''			
			),         			 	 
	);	
}
