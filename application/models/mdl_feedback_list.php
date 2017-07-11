<? // Модель отзывов 

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_feedback_list extends CI_Model {

	public function __construct () {    
    	parent:: __construct ();        
	}
     
    // Добавление нового отзыва
    public function feedback_add ($author, $date, $email, $text, $is_ajax = "") {
        
        $mdl = ($is_ajax !== "")? $this->feedback_update_this_rules_ajax : $this->feedback_update_this_rules;         
    	$this->form_validation->set_rules ($mdl);
		
		if ($this->form_validation->run ()) {       
        	foreach ($this->feedback_update_this_rules as $one) {
                $f = $one ['field'];
				$data [$f] = $this->input->post ($f);
            }   
            $data ['email'] = ($data ['email'] == "E-mail")? "" : $data ['email'];           
            $data ['parent_id'] = $this->input->post ('parent_id');
                       
            // Обновляем таблицу с отзывами (ci_feedback)
            $this->db->insert ("feedback", $data);           
            return TRUE;
		} else { 
            return FALSE;
        }    
    }
    
    // Обновление отзывов: автор, дата, текст отзыва, триггер "на сайте" 
    public function feedback_update_this ($author, $date, $text, $on_site, $feedback_id) {  

       	$this->form_validation->set_rules ($this->feedback_update_this_rules);
           
        if ($this->form_validation->run ()) {       
        	foreach ($this->feedback_update_this_rules as $one) {
                $f = $one ['field'];
				$data [$f] = $this->input->post ($f);
            }           
            $data ['date'] = mdl_date::olddate ($data ['date'], ".");
                        
            // Обновляем таблицу с отзывами (ci_feedback)
            $this->db->update ("feedback", $data, "id = $feedback_id");            
            return TRUE;
		} else { 
            return FALSE;
        }           
    }
    
    // Обновление названия отзывов 
    public function feedbacks_update_params ($module_id, $title, $from_site) { 
                
    	$this->form_validation->set_rules ($this->feedbacks_update_params_rules);
		
		if ($this->form_validation->run ()) {      
        	$data ['title'] = $title;
            $data ['from_site'] = $from_site;  
                               
            // Обновляем таблицу ci_feedback_list
            $this->db->update ("feedback_list", $data, "id = $module_id");          
            return TRUE; 
		} else { 
            return FALSE;
        }    
    }
    
    public function feedback_del ($feedback_id) {    
        $this->db->delete ("feedback", "id = $feedback_id");
        return TRUE;        
    }     
   
}
    