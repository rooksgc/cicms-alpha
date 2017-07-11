<? // Контроллер Отзывов

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Feedback_list extends CI_Controller {

    public $vm = 'mdl_feedback_list_validate';

    function __construct () {		
		parent:: __construct (); 
		$this->lib_auth->check_admin ();
        $this->load->model ('mdl_feedback_list');
        $this->load->model ($this->vm);			        
	}
    
    // Добавление отзыва
    public function feedback_add () {  
              
        $author = $this->input->post ('author');
        $date = $this->input->post ('date');
        $email = $this->input->post ('email');
        $text = $this->input->post ('text');
        $id = $this->input->post ('id');
        $number = $this->input->post ('number');            
            
        if ($this->{$this->vm}->feedback_add ($author, $date, $email, $text) !== FALSE) {    
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = 'Отзыв добавлен!';                     
            $this->session->set_flashdata ($mes);
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);
        } else {
            $mes ['count'] = 1; $mes ['go'] = $number;  
            $mes [] = validation_errors ();              
            $this->session->set_flashdata ($mes);                                             
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);
        }   
    }

    // Удаление отзыва
    public function feedback_del () {
        
        $id = $this->input->post ('id'); 
        $number = $this->input->post ('number');
        $feedback_id = $this->input->post ('feedback_id');
            
        if ($this->{$this->vm}->feedback_del ($feedback_id) !== FALSE) {                 
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = 'Отзыв удален!';                       
            $this->session->set_flashdata ($mes);                
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);  
        } else { 
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = validation_errors ();
            $this->session->set_flashdata ($mes);                                                               
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);
        }                   
    } 
            
    // Обновление отзыва
    public function feedback_update_this () {
    
        $id = $this->input->post ('id');
        $feedback_id = $this->input->post ('feedback_id');
        $number = $this->input->post ('number');
        $author = $this->input->post ('author');
        $date = $this->input->post ('date');
        $text = $this->input->post ('text'); 
        $on_site = ($this->input->post ('on_site') !== FALSE)? 1 : 0;
            
        if ($this->{$this->vm}->feedback_update_this ($author, $date, $text, $on_site, $feedback_id) !== FALSE) {     
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = 'Отзыв отредактирован!';                       
            $this->session->set_flashdata ($mes);                
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);  
        } else { 
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = validation_errors ();
            $this->session->set_flashdata ($mes);                                                               
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);   
        }
    }
        
    // Сохранение названия отзывов и возможности отправки с сайта
    public function feedbacks_update_params () {
        
        $module_id = $this->input->post ('module_id');
        $title = $this->input->post ('title');          
        $from_site = $this->input->post ('from_site');  
            
        if ($this->{$this->vm}->feedbacks_update_params ($module_id, $title, $from_site) !== FALSE) {     
            $resp = 'Параметры сохранены!';               
        } else { $resp = validation_errors (); }   
        // Ответ Ajax
        if ($this->input->is_ajax_request ()) {echo $resp; exit;}   
    }    
    
}