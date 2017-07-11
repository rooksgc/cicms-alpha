<? // Модель загрузки настроек

if (!defined ('BASEPATH')) exit ('BASEPATH UNDEFINED');

class Mdl_set extends CI_Model {	
	
	public function __construct () {		
        parent:: __construct ();        
		$this->load_config ();         
	}
	
	// Загружаем настройки из базы
	public function load_config () {
    		
        $qr = $this->db->get ("settings");       
        $sets = $qr->result ();     
                
        foreach ($sets as $row) {   

            $val = $row->value;
            
            if (is_numeric ($val)) {  // Проверка на число 
                $val = $val + 0;      // и преобразование
            }
                                    
            $this->config->set_item ($row->param, $val);  // Установка соответствия параметра и значения
        }        		
	}		
}
