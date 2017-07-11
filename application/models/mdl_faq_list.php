<? // Модель вопросов-ответов

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_faq_list extends CI_Model {

	public function __construct () {    
    	parent:: __construct ();        
	}
     
    // Добавление нового вопроса-ответа
    public function faq_add ($author, $date, $email, $question, $answer) {
                 
    	$this->form_validation->set_rules ($this->faq_update_this_rules);
		
		if ($this->form_validation->run ()) {       
        	foreach ($this->faq_update_this_rules as $one) {
                $f = $one ['field'];
				$data [$f] = $this->input->post ($f);
            }   
            $data ['email'] = ($data ['email'] == "E-mail")? "" : $data ['email'];           
            $data ['parent_id'] = $this->input->post ('parent_id');
            if ($data ['answer'] == NULL) unset ($data ['answer']);
                       
            // Обновляем таблицу с вопросами-ответами (ci_faq)
            $this->db->insert ("faq", $data);           
            return TRUE;
		} else { 
            return FALSE;
        }    
    }
    
    // Обновление конкретного поля вопроса-ответа 
    public function faq_update_this ($author, $date, $question, $answer, $on_site) {  

       	$this->form_validation->set_rules ($this->faq_update_this_rules);
           
        if ($this->form_validation->run ()) {       
        	foreach ($this->faq_update_this_rules as $one) {
                $f = $one ['field'];
				$data [$f] = $this->input->post ($f);
            }           
            $id = $this->input->post ('id');
            $data ['date'] = mdl_date::olddate ($data ['date'], ".");
                        
            // Обновляем таблицу с вопросами-ответами (ci_faq)
            $this->db->update ("faq", $data, "id = $id");            
            return TRUE;
		} else { 
            return FALSE;
        }           
    }
    
    // Обновление параметров вопросов-ответов 
    public function faq_update_params ($module_id, $title, $email, $from_site) { 
                
    	$this->form_validation->set_rules ($this->faq_update_params_rules);
		
		if ($this->form_validation->run ()) {      
        	foreach ($this->faq_update_params_rules as $one) {
                $f = $one ['field'];
				$data [$f] = $this->input->post ($f);
            }                 
            // Обновляем таблицу ci_faq_list
            $this->db->update ("faq_list", $data, "id = $module_id");          
            return TRUE; 
		} else { 
            return FALSE;
        }    
    }
    
    public function faq_del ($faq_id) {    
        $this->db->delete ("faq", "id = $faq_id");
        return TRUE;        
    }     
   
}
    