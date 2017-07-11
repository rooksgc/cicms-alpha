<? // Контроллер настроек модулей cms

if (!defined ('BASEPATH')) exit ('BASEPATH UNDEFINED');

class Modules extends CI_Controller {
	
    public $vm = 'mdl_modules_validate';
    
	function __construct () {		
        parent:: __construct ();
		$this->lib_auth->check_admin ();
        $this->load->model ($this->vm);
    }
    
	public function index () {            	                   
		crud::admin_page ('modules', '', 'Настройка модулей');
    }
        
    // Добавление категории блога
    public function blog_category_add () {
            
        $this->form_validation->set_rules ($this->{$this->vm}->add_category_rules);
                
        if ($this->form_validation->run ()) {
                
            $category = trim ($this->input->post ('new_category_title'));                     
            $this->db->insert ("blog_categories", array ("title" => $category));
                        
            $mes ['count'] = 1; $mes [] = "Категория '$category' добавлена!";                             
            $this->session->set_flashdata ($mes);      
            redirect ('admin/modules');            
        } else { 
            modules::index ();
        }                      
    }
            
    // Редактирование категории блога
    public function blog_category_edit () {
                
        $this->form_validation->set_rules ($this->{$this->vm}->edit_category_rules);
                
        if ($this->form_validation->run ()) {
                  
            $category = trim ($this->input->post ('category_title'));
            $id = $this->input->post ('id'); 
            
            // Проверка на уникальность названия категории
            $qr = $this->db->select ("title")->from ("blog_categories")->where ("id", $id)->get ();
            $old = $qr->row_array ();      
            $this->db->where ("title", $category);           
            if ($this->db->count_all_results ("blog_categories") > 0 && $category !== $old ['title']) {
                $mes ['count'] = 1; $mes [] = "Категория '$category!' уже существует! Введите уникальное название"; 
                $this->session->set_flashdata ($mes);   
                redirect ('admin/modules');              
            }
                                                   
            $this->db->update ("blog_categories", array ("title" => $category), "id = $id"); 
                         
            $mes ['count'] = 1; $mes [] = 'Категория отредактирована!'; 
            $this->session->set_flashdata ($mes);   
            redirect ('admin/modules');                                            
        } else { 
            modules::index ();
        } 
    }   
            
    // Удаление категории блога
    public function blog_category_delete () {
            
        $category = $this->input->post ('category_title');               
        $id = $this->input->post ('id');
    
        $this->db->delete ("blog_categories", "id = $id");
                    
        $mes ['count'] = 1; $mes [] = "Категория '$category' удалена!";                         
        $this->session->set_flashdata ($mes);   
        redirect ('admin/modules');                                                
    }   
            
    // Обновление настроек капчи
    public function captcha_params_save () {
                                  
        foreach ($this->input->post () as $key=>$val) {
            $data [$key] = $this->input->post ($key); 
        }
        $info = serialize ($data);
        unset ($data);
        $data ['value'] = $info;
                
        $this->db->update ("settings", $data, "param = 'captcha_info'"); 
                         
        $mes ['count'] = 1;
        $mes [] = 'Настройки капчи сохранены!'; 
        $this->session->set_flashdata ($mes);     
        redirect ('admin/modules');         
    }    
    
    public function faq_global_email_update () {
            
        $this->form_validation->set_rules ($this->{$this->vm}->faq_global_email_rules);
                
        if ($this->form_validation->run ()) {
                
            $data ['value'] = $this->input->post ('faq_global_email');                     
            
            $this->db->update ("settings", $data, "param = 'faq_global_email'"); 
                         
            $mes ['count'] = 1;
            $mes [] = 'E-mail сохранен!'; 
            $this->session->set_flashdata ($mes);     
            redirect ('admin/modules');            
        } else { 
            modules::index ();
        }                      
    }
          
                     				
}