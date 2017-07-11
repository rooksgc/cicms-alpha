<? // Модель вставок

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_includes extends CI_Model {

	public function __construct () {    
    	parent:: __construct ();        
	}
     
    // Добавление новой вставки
    public function include_add ($id, $title, $alias, $text) {
        
        $this->form_validation->set_rules ($this->edit_includes_rules);
		
		if ($this->form_validation->run ()) {       
        	foreach ($this->edit_includes_rules as $one) {
                $f = $one ['field'];
				$data [$f] = $this->input->post ($f);
            }   

            $this->db->insert ("includes", $data);           
            return TRUE;
		} else { 
            return FALSE;
        }    
    }
    
    // Обновление вставки: название, алиас, текст 
    public function include_edit ($id, $title, $alias, $text) {  

       	$this->form_validation->set_rules ($this->edit_includes_rules);
           
        if ($this->form_validation->run ()) {       
        	foreach ($this->edit_includes_rules as $one) {
                $f = $one ['field'];
				$data [$f] = $this->input->post ($f);
            }           

            $this->db->update ("includes", $data, "id = $id");            
            return TRUE;
		} else { 
            return FALSE;
        }           
    }
    
    public function include_del ($id) {    
        $this->db->delete ("includes", "id = $id");
        return TRUE;        
    } 
    
}
    