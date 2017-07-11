<? // Контроллер Галереи

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Gallery_list extends CI_Controller {

    public $vm = 'mdl_gallery_list_validate';

    function __construct () {		
		parent:: __construct (); 
		$this->lib_auth->check_admin ();
        $this->load->model ('mdl_gallery_list');
        $this->load->model ($this->vm);			        
	}
                          
    // Добавление изображений
    public function gallery_images_add () {

        $id = $this->input->post ('id');
        $number = $this->input->post ('number');
        $module_id = $this->input->post ('module_id');  // ID галереи в таблице ci_gallery_list
        $creation_type = $this->input->post ('creation_type');   // Логика создания миниатюры
        $width = $this->input->post ('width');          // Ширина миниатюры
        $height = $this->input->post ('height');        // Высота миниатюры        
         
        $this->load->library ('lib_check_ext');
                  
        $whitelist = array ('.jpg', '.jpeg', '.png', '.gif');   // Задаем список допустимых расширений файлов  
        $fileslist = $_FILES ['imgfiles'] ['name'];   // Массив имен изображений
            
        // Цикл проверки на допустимые расширения         
        if ($this->lib_check_ext->valid_ext_array ($whitelist, $fileslist) == FALSE) {         
            $mes ['count'] = 1; $mes ['go'] = $number;        
            $mes [] = 'Файлы не выбраны или имеют формат, отличный от JPG/JPEG/PNG/GIF!';
            $this->session->set_flashdata ($mes);                               
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);
        }            
                  
        $mes ['count'] = 1; $mes ['go'] = $number;        
        $mes [] = ($this->{$this->vm}->gallery_image_upload ($id, $module_id, $fileslist, $width, $height, $creation_type) !== FALSE)? 'Изображения добавлены!' : 'Ошибка добавления изображений!';
        
        $this->session->set_flashdata ($mes);                           
        redirect ('admin/pages/page_edit/'.$id.'#'.$number);
    }
        
    public function gallery_image_del () {
            
        $id = $this->input->post ('id');
        $number = $this->input->post ('number');
        $img_id = $this->input->post ('img_id');          // ID изображения
        $img_name = $this->input->post ('img_name');      // Имя файла
        $module_id = $this->input->post ('module_id');    // ID галереи в таблице ci_gallery_images
                                 
        if ($this->{$this->vm}->gallery_image_del ($img_id, $module_id, $img_name) !== FALSE) {   
            $mes ['count'] = 1; $mes ['go'] = $number; 
            $mes [] = 'Изображение удалено!';                       
            $this->session->set_flashdata ($mes);              
            redirect ('admin/pages/page_edit/'.$id.'#'.$number);
        }        
    }
        
    public function gallery_title_save () {
        
        $id = $this->input->post ('id');
        $module_id = $this->input->post ('module_id');
        $title = $this->input->post ('title');
        
        $resp = ($this->{$this->vm}->gallery_title_save ($id, $module_id, $title) !== FALSE)? 'Название галереи сохранено!' : validation_errors ();

        if ($this->input->is_ajax_request ()) {echo $resp; exit;}                    
    }
        
    public function gallery_update_image_params () {

        $img_id = $this->input->post ('img_id');
        $img_title = $this->input->post ('img_title');
        $img_alt = $this->input->post ('img_alt');
        
        $resp = ($this->{$this->vm}->gallery_update_image_params ($img_id, $img_title, $img_alt) !== FALSE)? 'Параметры изображения сохранены!' : validation_errors ();

        if ($this->input->is_ajax_request ()) {echo $resp; exit;}
    }                  
    
}