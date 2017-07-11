<? // Контроллер Вопросов-ответов

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Faq_list extends CI_Controller {

    public $vm = 'mdl_faq_list_validate';

    function __construct () {		
		parent:: __construct (); 
		$this->lib_auth->check_admin ();
        $this->load->model ('mdl_faq_list');
        $this->load->model ($this->vm);			        
	}
    
    // Добавление вопроса-ответа
    public function faq_add () {  
              
        $author = $this->input->post ('author');
        $date = $this->input->post ('date');
        $email = $this->input->post ('email');
        $question = $this->input->post ('question');
        $answer = $this->input->post ('answer');
        $id = $this->input->post ('id');
        $number = $this->input->post ('number');          
            
        if ($this->{$this->vm}->faq_add ($author, $date, $email, $question, $answer) !== FALSE) {    
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = 'Вопрос-ответ добавлен!';                     
            $this->session->set_flashdata ($mes);
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);
        } else {
            $mes ['count'] = 1; $mes ['go'] = $number;  
            $mes [] = validation_errors ();              
            $this->session->set_flashdata ($mes);                                             
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);
        }   
    }

    // Удаление вопроса-ответа
    public function faq_del () {
        
        $id = $this->input->post ('id'); 
        $number  = $this->input->post ('number');
        $faq_id = $this->input->post ('faq_id');
            
        if ($this->{$this->vm}->faq_del ($faq_id) !== FALSE) {                 
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = 'Вопрос-ответ удален!';                       
            $this->session->set_flashdata ($mes);                
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);  
        } else { 
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = validation_errors ();
            $this->session->set_flashdata ($mes);                                                               
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);
        }                   
    } 
            
    // Обновление конкретного вопроса-ответа
    public function faq_update_this () {
        
        $author = $this->input->post ('author');
        $date = $this->input->post ('date');
        $question = $this->input->post ('question');
        $answer = $this->input->post ('answer');
        $on_site = ($this->input->post ('on_site') !== FALSE)? 1 : 0;
            
        if ($this->{$this->vm}->faq_update_this ($author, $date, $question, $answer, $on_site) !== FALSE) {     
            $resp = 'Вопрос-ответ обновлен!';               
        } else { $resp = validation_errors (); }   
        // Ответ Ajax
        if ($this->input->is_ajax_request ()) {echo $resp; exit;}    
    }
        
    // Сохранение параметров вопрос-ответ
    public function faq_update_params () {
        
        $module_id = $this->input->post ('module_id');
        $title = $this->input->post ('title');
        $email = $this->input->post ('email');
        $from_site = $this->input->post ('from_site');
            
        if ($this->{$this->vm}->faq_update_params ($module_id, $title, $email, $from_site) !== FALSE) {     
            $resp = 'Параметры сохранены!';               
        } else { $resp = validation_errors (); }   
        // Ответ Ajax
        if ($this->input->is_ajax_request ()) {echo $resp; exit;}   
    }

    // Ajax отправка уведомления на e-mail об ответе
    public function faq_email_notice () {
        
        $faq_id = $this->input->post ('faq_id');
        $email = $this->input->post ('email');
        
        // Получатель
        $to = $email;
        $from = "donotreply@mail.ru";
        $sitename = $this->config->item ("sitename");
        
        // Тема
        $subject = "На ваш вопрос с сайта $sitename был дан ответ";
        $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    
    	$header = "MIME-Version: 1.0\r\n"; 
		$header.= "From: ".$from."\r\n";
		$header.= "Subject: ".$subject."\r\n";
		$header.= "Content-type: text/plain; charset=utf-8\r\n";

        // Сообщение
        $message = "На ваш вопрос с сайта $sitename был дан ответ! Посетите сайт для его просмотра.";

        // Отправка 
        if (@mail($to, $subject, $message, $header) !== FALSE) {
            $resp = "Уведомление об ответе отправлено на почту $email!";    
        } else { $resp = validation_errors (); }
        
        // Ставим маркер отправки уведомления 
        $this->db->update ("faq", array ("notice" => 1), "id = $faq_id");
        
        // Ответ Ajax
        if ($this->input->is_ajax_request ()) {echo $resp;
            ?><script>
                $(document).ready (function () {
                    $(".faq_notice"+"<?=$faq_id?>").remove();
                });
            </script><?
            exit;
        }
    }
        
    
}