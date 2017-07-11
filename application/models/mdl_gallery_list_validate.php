<? // Модель валидации для галереи

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_gallery_list_validate extends mdl_gallery_list {
	
    // Правила для названия галереи
    var $edit_gallery_images_rules = array (
		array (
			'field'	=> 'title',
			'label' => '\'Название\'',
			'rules' => 'trim|no_special_symbols'			
		)                        			 	 
	);
    
	// Правила валидации для параметров изображений в галерее
	var $edit_gallery_images_params_rules = array (
			array (
				'field'	=> 'img_title',
				'label' => '\'Название изображения\'',
				'rules' => 'trim|no_special_symbols'			
			),
			array (
				'field'	=> 'img_alt',
				'label' => '\'Альтернативное название изображения\'',
				'rules' => 'trim|no_special_symbols'			
			)                                    			 	 
	);	
    
}
