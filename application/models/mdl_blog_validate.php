<? // Модель валидации для записи блога

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_blog_validate extends CRUD {
	
	//Правила валидации для добавления страницы
	var $edit_blog_rules = array (
            array (
				'field'	=> 'head_title',
				'label'	=> '\'Заголовок (title)\'',
				'rules' => 'trim'				
			), 
            array (
				'field'	=> 'head_keywords',
				'label'	=> '\'Ключевые слова (keywords)\'',
				'rules' => 'trim'				
			), 
            array (
				'field'	=> 'head_description',
				'label'	=> '\'Описание (description)\'',
				'rules' => 'trim'				
			),
            array (
				'field'	=> 'date',
				'label'	=> '\'Дата\'',
				'rules' => 'no_special_symbols|max_length[10]'				
			),
            array (
				'field'	=> 'path',
				'label'	=> '\'URL\'',
				'rules' => 'trim|az_numeric|not_numeric'				
			),               
			array (
				'field'	=> 'title',
				'label' => '\'Название\'',
				'rules' => 'required|trim|no_special_symbols|not_numeric'			
			),  
			array (
				'field'	=> 'preview',
				'label'	=> '\'Анонс\'',
				'rules' => ''				
			),     
            array (
				'field'	=> 'author',
				'label' => '\'Автор\'',
				'rules' => 'trim|no_special_symbols'			
			), 
            array (
				'field'	=> 'text',
				'label' => '\'Текст записи\'',
				'rules' => ''			
			), 
            array (
				'field'	=> 'category_id',
				'label'	=> '\'ID Категории\'',
				'rules' => 'numeric'				
			),             			 	 
	);	
}
