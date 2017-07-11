<? // Контроллер Вставок

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Includes extends CI_Controller {

    public $vm = 'mdl_includes_validate';

    function __construct () {		
		parent:: __construct (); 
		$this->lib_auth->check_admin ();
        $this->load->model ('mdl_includes');
        $this->load->model ($this->vm);			        
	}

	public function index () { 
        $data ['data'] = crud::getElements (array ("table" => "includes", "order" => array ("by" => "id", "dir" => "ask")));                   	                   
		crud::admin_page ('includes', $data, 'Вставки');
    }
 
    // Добавление вставки
    public function include_add () {  
            
        $id = $this->input->post ('id');
        $title = $this->input->post ('title');
        $alias = $this->input->post ('alias');      
        $text = $this->input->post ('text');

        $mes [] = ($this->{$this->vm}->include_add ($id, $title, $alias, $text) !== FALSE)? 'Вставка добавлена!' : validation_errors ();                     
        $mes ['count'] = 1;
        $this->session->set_flashdata ($mes);                                             
        redirect ('admin/includes'); 
    } 
            
    // Обновление вставки
    public function include_edit () {
        
        $id = $this->input->post ('id');
        $title = $this->input->post ('title');
        $alias = $this->input->post ('alias');      
        $text = $this->input->post ('text');
        
        $mes [] = ($this->{$this->vm}->include_edit ($id, $title, $alias, $text) !== FALSE)? 'Вставка отредактирована!' : validation_errors ();                     
        $mes ['count'] = 1;
        $this->session->set_flashdata ($mes);                                             
        redirect ('admin/includes'); 
    } 
    
    // Удаление вставки
    public function include_del () {

        $id = $this->input->post ('id');
        
        $mes [] = ($this->{$this->vm}->include_del ($id) !== FALSE)? 'Вставка удалена!' : validation_errors ();               
        $mes ['count'] = 1;                 
        $this->session->set_flashdata ($mes);                
        redirect ('admin/includes');                       
    }     
        
    
}