<? // Модель валидации для настроек cms

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_settings_validate extends CI_Model {
	
	//Правила валидации для редактирования настроек
	var $edit_settings_rules = array (  
            array (
				'field' => 'email',
				'label' => '\'Основной E-mail\'',
				'rules' => 'valid_email',
			), 
            array (
				'field' => 'donotreply_email',
				'label' => '\'E-mail отправителя\'',
				'rules' => 'valid_email',
			),                             
            array (
				'field' => 'extra_info',
				'label' => '\'Расширенное оповещение\'',
				'rules' => 'numeric',
			),           
            array (
				'field' => 'benchmark',
				'label' => '\'Бенчмарк\'',
				'rules' => 'numeric',
			),         
            array (
				'field' => 'url_blacklist',
				'label' => '\'Список запрещенных URL\'',
				'rules' => 'trim|url_blacklist',
			)		 	 
	);	
}
