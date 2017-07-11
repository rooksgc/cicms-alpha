<? // Модель валидации для входа в админку

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_login_validate {
	
	//Правила валидации для входа
	var	$login_rules = array (		
		array (
			'field' => 'login',
			'label' => '\'Логин\'',
			'rules' => 'required|az_numeric|xss_clean',
		),		
		array (
			'field' => 'pass',
			'label' => '\'Пароль\'',
			'rules'	=> 'required|max_length[30]|xss_clean'			
		),		
	);	
}
