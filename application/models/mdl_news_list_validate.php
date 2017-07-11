<? // Модель валидации для новостей

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_news_list_validate extends mdl_news_list {

	// Обновление названия новостной ленты
	var $news_update_params_rules = array (     
            array (
				'field'	=> 'block_title',
				'label' => '\'Название ленты\'',
				'rules' => 'trim|no_special_symbols'			
			)        			 	 
	);

    // Добавление / Редактирование новости
	var $news_update_this_rules = array (  
            array (
				'field'	=> 'title',
				'label' => '\'Название\'',				
                'rules' => 'required|no_special_symbols|not_numeric'			
			), 
            array (
				'field'	=> 'path',
				'label' => '\'URL\'',				
                'rules' => 'trim|az_numeric|not_numeric'			
			),     
			array (
				'field'	=> 'author',
				'label' => '\'Автор\'',
				'rules' => 'trim|no_special_symbols'			
			),
            array (
				'field'	=> 'date',
				'label' => '\'Дата\'',				
                'rules' => 'no_special_symbols|max_length[10]'			
			),            
            array (
				'field'	=> 'announce',
				'label' => '\'Анонс\'',
				'rules' => ''			
			),            
            array (
				'field'	=> 'text',
				'label' => '\'Текст новости\'',
				'rules' => 'required'			
			),
            array (
				'field'	=> 'on_site',
				'label' => '\'Отображать новость на сайте\'',
				'rules' => 'numeric'			
			),
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
			)                                   			 	 
	);

}