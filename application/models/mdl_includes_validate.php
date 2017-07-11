<? // Модель валидации для вставок

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_includes_validate extends mdl_includes {
		
	//Правила валидации для добавления страницы
	var $edit_includes_rules = array (
			array (
				'field'	=> 'title',
				'label' => '\'Название\'',
				'rules' => 'required|trim|no_special_symbols'			
			),  
            array (
				'field'	=> 'alias',
				'label'	=> '\'Код\'',
				'rules' => 'trim|required|az_numeric|not_numeric'				
			), 
            array (
				'field'	=> 'text',
				'label' => '\'Содержание\'',
				'rules' => ''			
			)         			 	 
	);	
}
