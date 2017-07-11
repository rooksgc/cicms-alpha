<? // Контроллер страниц

if (!defined ('BASEPATH')) exit ('BASEPATH UNDEFINED');

class Pages extends CI_Controller {

    public $vm = 'mdl_page_validate';

    function __construct () {		
		parent:: __construct (); 
		$this->lib_auth->check_admin ();
        $this->load->model ($this->vm);			        
	}
	    
    // Показать дерево разделов
	public function index () {                   		           
    	crud::admin_page ('/index', '', 'Структура разделов');	
	}
	
	// Добавление нового раздела
 	public function page_add ($parent_id = '', $page_title = 'Добавление нового раздела') {
             
        if ($this->{$this->vm}->add_page () !== FALSE) {
            $mes ['count'] = 1; $mes [] = 'Страница добавлена!';
            $this->session->set_flashdata ($mes);                      
            redirect ('admin/pages');            	            
        } else {                                        
            $qr = $this->db->get_where ("menu", "id = $parent_id");            
    	    $new_row = $qr->row_array ();            
            $data = array ('parent_id' => $parent_id, 'path' => $new_row ['path']);                   		         
            (isset ($new_row ['title']) ? $data ['title'] = $new_row ['title'] : $data ['title'] = "");             
            crud::admin_page ('page_add', $data, $page_title);
        }
 	}  
    
	// Редактирование раздела
 	public function page_edit ($id, $page_title = 'Редактируем раздел') {
       
        $qr = $this->db->get_where ("menu", "id = $id");               
    	$data = $qr->row_array ();

        // Редактируем 
        if ($this->{$this->vm}->edit_page ($id) !== FALSE) {
            $mes ['count'] = 1; $mes [] = 'Раздел отредактирован!';            
            $this->session->set_flashdata ($mes);            
            redirect ("admin/pages/page_edit/$id");
        } else {                               	                             
            crud::admin_page ('page_edit', $data, $page_title);   
        }
 	}  
	
	// Удаление раздела
 	public function page_del ($id) {
       
        if ($this->{$this->vm}->del_page ($id) !== FALSE) {
            $mes ['count'] = 1; $mes [] = 'Раздел удален!';                      
            $this->session->set_flashdata ($mes);  
        }         
        redirect ('admin');
 	}
    
    // Удаление изображения раздела
    public function page_img_del () {
    
        $id = $this->input->post ('id');
        if ($this->{$this->vm}->page_img_del ($id) !== FALSE) {
            $mes ['count'] = 1; $mes [] = 'Изображение удалено!';                      
            $this->session->set_flashdata ($mes);  
        }
    }
     
    // Модули
    public function modules () {
       
        $task = $this->input->post ('task');
        $module = $this->input->post ('module');
        $id = $this->input->post ('id');        
        if ($this->input->post ('number') !== FALSE) $number = $this->input->post ('number');
        if ($this->input->post ('module_id') !== FALSE) $module_id = $this->input->post ('module_id');
       
        // Добавление модуля
        if ($task == "module_add") {
            crud::add_module ($id, $module);
        }
        
        // Редактирование модуля
        if ($task == "module_edit") {
                            
            switch ($module) {
                case 'articles' : $vmm = 'mdl_articles_validate'; $mod_name = 'Статья'; break;
                case 'blog': $vmm = 'mdl_blog_validate'; $mod_name = 'Запись блога'; break;   
            } 
            
            $this->load->model ($vmm);
            
            if ($this->{$vmm}->edit_module ($module_id, $module, $id) !== FALSE) {
                $mes ['count'] = 1; $mes ['go'] = $number;
                $mes [] = $mod_name.' обновлена!';                       
                $this->session->set_flashdata ($mes);                         
                redirect ('admin/pages/page_edit/'.$id.'#'.$number);                              
            } else {
                $mes ['count'] = 1; $mes ['go'] = $number;
                $mes [] = validation_errors ();                      
                $this->session->set_flashdata ($mes);                          
                redirect ('admin/pages/page_edit/'.$id).'#'.$number;           
            }
        }   

        // Удаление модуля
        if ($task == "module_delete") {                  
            crud::delete_module ($id, $module, $number, $module_id);
        }
        
    }
        
    // Счетчики - в новый контроллер для счетчиков
    public function counters () {
    
        $table = 'counters';
        $task = $this->input->post ('task');
        
        // Редактирование счетчика
        if ($task == "counter_edit") {
        
            $id = $this->input->post ('id');
            $month = $this->input->post ('month');
            $day = $this->input->post ('day');
            $hour = $this->input->post ('hour');
            $min = $this->input->post ('min');
            $sec = $this->input->post ('sec');
             
            $this->load->model ('mdl_counters_validate');
            $this->form_validation->set_rules ($this->mdl_counters_validate->edit_counters_rules);
		
    		if ($this->form_validation->run ()) { 
    			
    			$data = array (); 
                
    			foreach ($this->mdl_counters_validate->edit_counters_rules as $one) {
                        $f = $one ['field'];
    				    $data [$f] = $this->input->post ($f);     								
    			} 
                unset ($data ['id'], $data ['task']); 
                              
    			$this->db->update ($table, $data, "id = $id");
    			$resp = 'Изменения сохранены!'; 
                                     			
    		} else { $resp = validation_errors (); }
            // Ответ Ajax
            if ($this->input->is_ajax_request ()) {echo $resp; exit;}    
        }        
    }
  
}