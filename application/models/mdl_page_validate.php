<? // Модель валидации для страниц

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_page_validate extends CRUD {
	
	//Правила валидации для добавления страницы
	var $add_page_rules = array (    
            array (
				'field'	=> 'head_title',
				'label'	=> '\'Заголовок (title)\'',
				'rules' => 'trim|no_special_symbols'				
			),  
            array (
				'field'	=> 'head_keywords',
				'label'	=> '\'Ключевые слова (keywords)\'',
				'rules' => 'trim|no_special_symbols'				
			),  
            array (
				'field'	=> 'head_description',
				'label'	=> '\'Описание (description)\'',
				'rules' => 'trim|no_special_symbols'				
			),
            array (
				'field'	=> 'parent_id',
				'label'	=> '\'ID предка\'',
				'rules' => 'required|numeric'				
			),    
            array (
				'field'	=> 'p_path',
				'label'	=> '\'URL\'',
				'rules' => 'required|valid_path'				
			),             
			array (
				'field'	=> 'title',
				'label' => '\'Название\'',
				'rules' => 'trim|required|no_special_symbols|not_numeric'			
			),
			array (
				'field'	=> 'template',
				'label'	=> '\'Шаблон\'',
				'rules' => 'required'				
			),                       
            array (
				'field'	=> 'showed',
				'label' => '\'Показывать\'',
				'rules' => 'numeric'			
			), 	
            array (
				'field'	=> 'in_menu',
				'label' => '\'В меню\'',
				'rules' => 'numeric'			
			)            		 	
	);
	
	//Правила валидации для редактирования страницы
	var $edit_page_rules = array (      
			array (
				'field'	=> 'head_title',
				'label'	=> '\'Заголовок (title)\'',
				'rules' => 'trim|no_special_symbols'				
			),            
            array (
				'field'	=> 'head_keywords',
				'label'	=> '\'Ключевые слова (keywords)\'',
				'rules' => 'trim|no_special_symbols'				
			),            
            array (
				'field'	=> 'head_description',
				'label'	=> '\'Описание страницы (description)\'',
				'rules' => 'trim|no_special_symbols'				
			),            
			array (
				'field'	=> 'title',
				'label' => '\'Название\'',
				'rules' => 'trim|required|no_special_symbols'
			),
            array (
				'field'	=> 'p_path',
				'label'	=> '\'PRE-URL\'',
				'rules' => 'trim|valid_path|not_numeric'				
			),    
            array (
				'field'	=> 'path',
				'label'	=> '\'URL\'',
				'rules' => 'trim|required|az_numeric|not_numeric'				
			),            
			array (
				'field'	=> 'template',
				'label'	=> '\'Шаблон\'',
				'rules' => 'required'				
			),             
            array (
				'field'	=> 'pagination',
				'label'	=> '\'Пейджинг\'',
				'rules' => 'trim|numeric'				
			),             
            array (
				'field'	=> 'showed',
				'label' => '\'Показывать\'',
				'rules' => 'numeric'			
			), 	
            array (
				'field'	=> 'in_menu',
				'label' => '\'В меню\'',
				'rules' => 'numeric'			
			),
            array (
				'field'	=> 'on_main',
				'label' => '\'На главной\'',
				'rules' => 'numeric'			
			)  		 
	);	
}
