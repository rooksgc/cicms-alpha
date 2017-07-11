<? // Модель Новостей 

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Mdl_news_list extends CI_Model {

	public function __construct () {    
    	parent:: __construct ();        
	}
     
    // Добавление новости
    public function news_add ($title, $path, $author, $date, $on_site, $head_title, $head_keywords, $head_description, $announce, $text) {
                
    	$this->form_validation->set_rules ($this->news_update_this_rules);
		
		if ($this->form_validation->run ()) {       
        	foreach ($this->news_update_this_rules as $one) {
                $f = $one ['field'];
				$data [$f] = $this->input->post ($f);
            }
            
            $data ['parent_id'] = $this->input->post ('parent_id');
            $data ['date'] = ($data ['date'] == "")? date ("Y-m-d") : mdl_date::olddate ($data ['date'], ".");  
            
            if ($data ['path'] == "") {
                $this->load->library ('lib_transliteration');
                $data ['path'] = $this->lib_transliteration->translite ($data ['title']);   
            }                   
                                              
            // Обновляем таблицу с новостями (ci_news)
            $this->db->insert ("news", $data);           
            return TRUE;
		} else { 
            return FALSE;
        }    
    }
    
    // Обновление новости 
    public function news_update_this ($title, $path, $author, $date, $head_title, $head_keywords, $head_description, $on_site, $announce, $text, $news_id, $id, $number) {  

       	$this->form_validation->set_rules ($this->news_update_this_rules);
         
        if ($this->form_validation->run ()) {       
        	foreach ($this->news_update_this_rules as $one) {
                $f = $one ['field'];
				$data [$f] = $this->input->post ($f);
            } 
            
            // Формируем path для страницы с новостью
            if ($data ['path'] == "") {
                $this->load->library ('lib_transliteration');
                $data ['path'] = $this->lib_transliteration->translite ($data ['title']);   
            } 
                        
            // Проверка на уникальность path
            $qr = $this->db->select ("path")->from ("news")->where ("id", $news_id)->get ();
            $old = $qr->row_array (); 
            $this->db->where ("path", $data ['path']);
                                    
            if (($this->db->count_all_results ("news") > 0 && $data ['path'] !== $old ['path']) || crud::url_blacklist ($data ['path']) == FALSE) {                                  
                $mes ['count'] = 1; $mes ['go'] = $number;
                $mes [] = 'Новость с указанным URL уже существует<br />или URL находится в списке запрещенных.<br />Пожалуйста, введите уникальный путь!';
                $this->session->set_flashdata ($mes);     
                redirect ('admin/pages/page_edit/'.$id.'#'.$number);                                     
            } 
            
            $data ['date'] = ($data ['date'] == "")? date ("Y-m-d") : mdl_date::olddate ($data ['date'], ".");

            // Если загружено изображение              
            if ($_FILES ['newsimg']['size'] > 0) { 
                $news_img = $_FILES ['newsimg']['name'];
                $this->load->library ('lib_check_ext');                          
                $whitelist = array ('.jpg', '.jpeg', '.png', '.gif');   // Задаем список допустимых расширений  
                        
                // Цикл проверки на допустимые расширения         
                if ($this->lib_check_ext->valid_ext ($whitelist, $news_img) == FALSE) {         
                    $mes ['count'] = 1; 
                    $mes [] = 'Файл изображения имеет формат, отличный от JPG/JPEG/PNG/GIF!';           
                    $this->session->set_flashdata ($mes);            
                    redirect ('admin/pages/page_edit/'.$id.'#'.$number);
                }
                    
                // Загружаем изображение     
                $extension = strtolower (end(explode (".", $news_img)));      // Расщирение изображения  
                $cur = $news_id.".".$extension;    // Имя нового файла 
                $uploaddir = "img/news/";     // Папка загрузки
                    
                // Если файл уже загружен - удаляем     
                foreach ($whitelist as $ext) {
                    $n_img = "img/news/".$news_id.$ext;
                    if (is_file ($n_img)) { @unlink ($n_img); }
                }

                $this->load->library ('lib_image');

                if (move_uploaded_file ($_FILES['newsimg']['tmp_name'], $uploaddir . $cur)) {                      
                    $source_image = 'img/news/'.$cur;
                    $mini_image = 'img/news/mini/'.$cur;   
                    $this->lib_image->load ($source_image);     // Загрузка изображения 
                        
                    // Большое изображение для новости
                    $this->lib_image->resize_crop ("480", "164")->save ($source_image, $overwrite=TRUE); 
                        
                    // Миниатюра для админки    
                    $this->lib_image->resize ("50", "50")->save ($mini_image, $overwrite=TRUE);                                                                        
                } else {
                    $mes ['count'] = 1;        
                    $mes [] = 'При загрузке изображения возникли ошибки:<br />'.$_FILES['newsimg']['error'];
                    $this->session->set_flashdata ($mes);     
                    return FALSE;   
                }                          
            } 
            
            // Обновляем таблицу с новостью (ci_news)
            $this->db->update ("news", $data, "id = $news_id");            
            return TRUE;
		} else { 
            return FALSE;
        }           
    }
    
    // Удаление изображения новости
    public function news_img_del ($id) {
        $extension = array ('.jpg', '.jpeg', '.png', '.gif');      
        foreach ($extension as $ext) {
            $n_img = "img/news/".$id.$ext;
            $mini_img = "img/news/mini/".$id.$ext;
            if (is_file ($n_img)) { 
                @unlink ($n_img);
                @unlink ($mini_img);                
                return TRUE;
            }
        }
        return FALSE;                  
    }    
    
    // Обновление названия новостной ленты 
    public function news_update_params ($module_id, $block_title) { 
                
    	$this->form_validation->set_rules ($this->news_update_params_rules);
		
		if ($this->form_validation->run ()) {     
        	$data ['block_title'] = $this->input->post ('block_title'); 
                          
            // Обновляем таблицу ci_news_list
            $this->db->update ("news_list", $data, "id = $module_id");          
            return TRUE; 
		} else { 
            return FALSE;
        }    
    }
    
    public function news_del ($news_id) {    
        // Удаляем изображение новости
        $this->news_img_del ($news_id); 
        // Удаляем саму новость   
        $this->db->delete ("news", "id = $news_id");
        return TRUE;        
    }     
   
}    