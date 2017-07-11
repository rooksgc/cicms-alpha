<? // Модель галереи 

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_gallery_list extends CI_Model {

	function __construct () {
    	parent:: __construct ();
	}
    
    // Загрузка изображений и создание миниатюр
    public function gallery_image_upload ($id, $module_id, $fileslist, $width, $height, $creation_type) { 
        
        if (!file_exists ('img/gallery/'.$module_id)) {
            mkdir ('img/gallery/'.$module_id, 0700);     // Создаем папку для галереи, если ее еще нет       
        } 
        
        $uploaddir = 'img/gallery/'.$module_id.'/';

        $this->load->library ('lib_image');              // Загружаем библиотеку для работы с изображениями
        $this->load->library ('lib_check_same_name');
        
        for ($i = 0; $i < count ($_FILES ['imgfiles']['tmp_name']); $i++) {        
            // Проверяем наличие файла с таким же названием в базе
            $cur = $_FILES ['imgfiles']['name'][$i];
            
            if ($this->lib_check_same_name->same_name ($cur, 'img', 'gallery') !== FALSE) {               
                $cur = $this->lib_check_same_name->same_name ($cur, 'img', 'gallery');                                
            }
            
            $cur = strtr ($cur, " ", "_");   // Заменяем пробелы в названии на "_"

            if (move_uploaded_file ($_FILES ['imgfiles']['tmp_name'][$i], $uploaddir.$cur)) {                      
                $source_image = $uploaddir.$cur;            // Путь к оригинальному изображению
                $this->lib_image->load ($source_image);     // Загрузка оригинала изображения
                
                switch ($creation_type) {    // Считываем логику создания миниатюры
                    case 'resize' : $this->lib_image->resize ($width, $height, $pad = TRUE); break; // Обрезать, вписать
                    case 'resize_crop' : $this->lib_image->resize_crop ($width, $height); break;    // Обрезать, заполнить 
                } 
                                       
                $this->lib_image->save_pa ($prepend="", $append="_mini", $overwrite = FALSE); // Сохранить файл миниатюры    
                
                // Присвоение номера сортировки
                $qr_sort = $this->db->select_max ("sort")->from ("gallery")->where ("gallery_id", $module_id)->get ();
                $max_sort = $qr_sort->row_array ();
                $sort = ($max_sort ['sort'] !== "")? $max_sort ['sort'] + 1 : 0;
                
                $data = array ('gallery_id' => $module_id, 'img' => $cur, 'sort' => $sort);
                $this->db->insert ("gallery", $data);                                             
            } else {
                $mes ['count'] = 1;        
                $mes [] = 'При загрузке возникли ошибки:<br />'.$_FILES ['imgfiles']['error'][$i];
                $this->session->set_flashdata ($mes);     
                return FALSE;   
            }
        }
        return TRUE;
    }
    
    // Удаление изображения
    public function gallery_image_del ($img_id, $module_id, $img_name) {
    
        // Cоздаем имя мини-файла
        $ppos = strrpos ($img_name, '.');
        $mini_name = substr ($img_name, 0, $ppos).'_mini.'.substr ($img_name, $ppos + 1);
        
        // Удаляем большой файл
        @unlink ('img/gallery/'.$module_id.'/'.$img_name); 
        
        // Удаляем миниатюру
        @unlink ('img/gallery/'.$module_id.'/'.$mini_name);     
        
        // Удаляем запись о файле из таблицы ci_gallery
        $this->db->delete ("gallery", "id = $img_id");
        
        // Пересортировка изображений
        tree::resort ('gallery', 'gallery_id', $module_id);
        
        return TRUE;        
    }
    
    // Применение настроек галереи: название
    public function gallery_title_save ($id, $module_id, $title) {	
 
    	$this->form_validation->set_rules ($this->edit_gallery_images_rules);
		
		if ($this->form_validation->run ()) {       
        	$data = array ();			
			foreach ($this->edit_gallery_images_rules as $one) {				
				$f = $one ['field'];
				$data [$f] = $this->input->post ($f);
			}
            // Обновляем таблицу ci_gallery_list
            $this->db->update ("gallery_list", $data, "id = $module_id");   
            return TRUE;            
        } else { 
            return FALSE;
        }
    } 
    
    // Применение праметров изображения в галерее: img_title, img_alt
    public function gallery_update_image_params ($img_id, $img_title, $img_alt) {    
      
    	$this->form_validation->set_rules ($this->edit_gallery_images_params_rules);
		
		if ($this->form_validation->run ()) {       
        	$data = array ();			
			foreach ($this->edit_gallery_images_params_rules as $one) {				
				$f = $one ['field'];
				$data [$f] = $this->input->post ($f);
			}          
            // Обновляем таблицу ci_gallery
            $this->db->update ("gallery", $data, "id = $img_id");   
            return TRUE;            
        } else {
            return FALSE;
        }
    }          
    
}