<? // Контроллер настроек cms

if (!defined ('BASEPATH')) exit ('No direct script access allowed');

class Settings extends CI_Controller {
	
    public $vm = 'mdl_settings_validate';
    
	function __construct () {  		
        parent:: __construct ();
		$this->lib_auth->check_admin ();
        $this->load->model ($this->vm);
    }
 
	public function index () {
		
		$this->form_validation->set_rules ($this->{$this->vm}->edit_settings_rules);
        		
		if ($this->form_validation->run ()) {
        
            $blacklist = str_replace (' ', '', $this->input->post ('url_blacklist'));   
            $url_blacklist = serialize (explode(',', $blacklist)); 
                            
			$data = array (
                'email' => $this->input->post ('email'),
                'donotreply_email' => $this->input->post ('donotreply_email'),
                'extra_info' => $this->input->post ('extra_info'),
                'benchmark' => $this->input->post ('benchmark'),
                'url_blacklist' => $url_blacklist,
                'profiler' => $this->input->post ('profiler') 
            ); 
            
			foreach ($data as $key => $value) {                       
				$this->db->update ("settings", array ("value" => $value), "param = \"$key\"");                  			
			}
                        
            $mes ['count'] = 1;
            $mes [] = 'Настройки сохранены';           
            $this->session->set_flashdata ($mes);
            redirect ('admin/settings');	
		} else {            	        
			crud::admin_page ('settings', '', 'Настройки cms');
		}			
	}	
}
