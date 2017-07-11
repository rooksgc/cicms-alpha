<? // Модель валидации для счетчиков

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_counters_validate extends CRUD {

    //Правила валидации для редактирования счетчиков
	var $edit_counters_rules = array (
            array (
				'field'	=> 'id',
				'label' => '\'ID\'',
				'rules' => ''			
			), 
            array (
				'field'	=> 'task',
				'label' => '\'Задача\'',
				'rules' => ''			
			), 
			array (
				'field'	=> 'month',
				'label' => '\'Месяцев\'',
				'rules' => 'trim|numeric|max_length[2]'			
			),       
            array (
				'field'	=> 'day',
				'label' => '\'Дней\'',				
                'rules' => 'trim|numeric|max_length[2]'			
			),    
            array (
				'field'	=> 'hour',
				'label' => '\'Часов\'',				
                'rules' => 'trim|numeric|max_length[2]'			
			),    
            array (
				'field'	=> 'min',
				'label' => '\'Минут\'',				
                'rules' => 'trim|numeric|max_length[2]'			
			),
            array (
				'field'	=> 'sec',
				'label' => '\'Секунд\'',
				'rules' => 'trim|numeric|max_length[2]'			
			)                      			 	 
	);	
}
