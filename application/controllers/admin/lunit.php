<? // Контроллер входа/выхода

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Lunit extends CI_Controller {

    var $validation_model = 'mdl_login_validate';

	function __construct () {		
        parent:: __construct ();
        $this->load->model ($this->validation_model);
    }
    
	function login () {   
        // Вход в админку в случае введения верных данных
		$this->form_validation->set_rules ($this->{$this->validation_model}->login_rules);
     
		if ($this->form_validation->run ()) {			
			$this->lib_auth->do_login ($this->input->post ('login'), $this->input->post ('pass'));			
		} else {
			// Если валидация провалена         
			$data ['page_title'] = 'Вход в панель управления';
            $data ['auth_page'] = 1;
            $data ['validation_errors'] = validation_errors ();                                
            $this->load->view ('login', $data);		
        }	
	}
	
	function logout () {   
		// Проверка был ли вход
		$this->lib_auth->check_admin ();		
		$this->lib_auth->logout ();
	}	
}
