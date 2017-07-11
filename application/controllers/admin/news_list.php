<? // Контроллер Новостей

if (!defined ('BASEPATH')) exit ('basepath undefined');

class News_list extends CI_Controller {

    public $vm = 'mdl_news_list_validate';

    function __construct () {		
		parent:: __construct (); 
		$this->lib_auth->check_admin ();
        $this->load->model ('mdl_news_list');
        $this->load->model ($this->vm);			        
	}
    
    // Добавление новости
    public function news_add () {  
        
        $title = $this->input->post ('title');
        $path = $this->input->post ('path');      
        $author = $this->input->post ('author');
        $date = $this->input->post ('date');
        $on_site = $this->input->post ('on_site');
        $head_title = $this->input->post ('head_title');
        $head_keywords = $this->input->post ('head_keywords');
        $head_description = $this->input->post ('head_description');
        $announce = $this->input->post ('announce');
        $text = $this->input->post ('text');
        $id = $this->input->post ('id');
        $number = $this->input->post ('number');            
            
        if ($this->{$this->vm}->news_add ($title, $path, $author, $date, $head_title, $head_keywords, $head_description, $on_site, $announce, $text) !== FALSE) {    
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = 'Новость добавлена!';                     
            $this->session->set_flashdata ($mes);
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);
        } else {
            $mes ['count'] = 1; $mes ['go'] = $number;  
            $mes [] = validation_errors ();              
            $this->session->set_flashdata ($mes);                                             
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);
        }   
    }

    // Удаление новости
    public function news_del () {
        
        $id = $this->input->post ('id'); 
        $number = $this->input->post ('number');
        $news_id = $this->input->post ('news_id');
            
        if ($this->{$this->vm}->news_del ($news_id) !== FALSE) {                 
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = 'Новость удалена!';                       
            $this->session->set_flashdata ($mes);                
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);  
        } else { 
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = validation_errors ();
            $this->session->set_flashdata ($mes);                                                               
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);
        }                   
    } 
    
    // Удаление изображения новости
    public function news_img_del () {
    
        $id = $this->input->post ('id');
        if ($this->{$this->vm}->news_img_del ($id) !== FALSE) {
            $mes ['count'] = 1; $mes [] = 'Изображение удалено!';                      
            $this->session->set_flashdata ($mes);  
        }
    }    
            
    // Обновление новости
    public function news_update_this () {
        
        $title = $this->input->post ('title');
        $path = $this->input->post ('path');      
        $author = $this->input->post ('author');
        $date = $this->input->post ('date');
        $head_title = $this->input->post ('head_title');
        $head_keywords = $this->input->post ('head_keywords');
        $head_description = $this->input->post ('head_description');
        $on_site = ($this->input->post ('on_site') !== FALSE)? 1 : 0;
        $announce = $this->input->post ('announce');
        $text = $this->input->post ('text');
        $news_id = $this->input->post ('news_id');      
        $id = $this->input->post ('id');
        $number = $this->input->post ('number');
           
        if ($this->{$this->vm}->news_update_this ($title, $path, $author, $date, $head_title, $head_keywords, $head_description, $on_site, $announce, $text, $news_id, $id, $number) !== FALSE) {     
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = 'Новость отредактирована!';                       
            $this->session->set_flashdata ($mes);                
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);  
        } else { 
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = validation_errors ();
            $this->session->set_flashdata ($mes);                                                               
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);   
        }
    }
        
    // Обновление названия новостной ленты
    public function news_update_params () {
        
        $module_id = $this->input->post ('module_id');
        $block_title = $this->input->post ('block_title');           
  
        if ($this->{$this->vm}->news_update_params ($module_id, $block_title) !== FALSE) {     
            $resp = 'Название новостной ленты обновлено!';               
        } else { $resp = validation_errors (); }   
        // Ответ Ajax
        if ($this->input->is_ajax_request ()) {echo $resp; exit;}   
    }    
    
}