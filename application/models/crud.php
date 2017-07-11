<? // CRUD - основная модель для разделов

if(!defined ('BASEPATH')) exit ('basepath undefined');

class Crud extends CI_Model {

	public function __construct () {    
    	parent:: __construct ();        
	}
    
	// Добавление раздела 	
	public function add_page () {
    
		$this->form_validation->set_rules ($this->add_page_rules);
                        		
		if ($this->form_validation->run ()) {  // Если валидация прошла
               
			$data = array ();    
			foreach ($this->add_page_rules as $one) {            				
				$f = $one ['field'];
				$data [$f] = $this->input->post ($f);
			}
                         
            $qr = $this->db->select ("level")->from ("menu")->where ("id", $this->input->post ("parent_id"))->get ();
            $res = $qr->row_array ();
            
            // Формируем уровень и дату добавления раздела
            $level = $res ['level'] + 1;
            $data ['level'] = $level;
            $data ['date'] = date ("Y-m-d");
            $data ['in_menu'] = 1;
            
            // Формируем номер сортировки
            $qr_sort = $this->db->select_max ("sort")->from ("menu")->where ("parent_id", $this->input->post ("parent_id"))->get ();
            $max_sort = $qr_sort->row_array ();
            $data ['sort'] = ($max_sort ['sort'] !== "")? $max_sort ['sort'] + 1 : 0;  
            
            // Формируем path
			$this->load->library ('lib_transliteration');
            $data ['path'] = $this->lib_transliteration->translite ($data ['title']);
            $o_path = $data ['path'];                
            $data ['path'] = ($level > 1)? $data ['p_path'].'/'.$data ['path'] : $o_path;            
            unset ($data ['p_path']);
            
            if ($this->form_validation->uniq ($data ['path'], 'path') !== FALSE && $this->url_blacklist ($o_path) !== FALSE) {           
			    $this->db->insert ("menu", $data);
			    return $this->db->insert_id ();                                                    
            } else { 
                $mes ['count'] = 1;
                $mes [] = 'Раздел с указанным именем уже существует<br />или url находится в списке запрещенных.<br />Пожалуйста, введите уникальное название!';
                $this->session->set_flashdata ($mes);
                redirect ('admin/pages/');        
            }  		
		} else {                    			
			return FALSE;     	           
		}		
	}
    
	// Редактирование раздела
    public function edit_page ($id) { 
        
		$this->form_validation->set_rules ($this->edit_page_rules); 
        		
		if ($this->form_validation->run ()) {    // Валидация прошла
			$data = array (); 
            	   	
			foreach ($this->edit_page_rules as $one) {				
				$f = $one ['field'];		
				$data [$f] = $this->input->post ($f);
			}
                    
            $full_path = ($data ['p_path'] != '')? $data ['p_path'].'/'.$data ['path'] : $data ['path'];
                                      
            // Проверка на уникальность full_path
            $qr = $this->db->select ("level, path")->from ("menu")->where ("id", $id)->get ();
            $old = $qr->row_array (); 
                       
            $this->db->where ("path", $full_path); 
                                
            if (($this->db->count_all_results ("menu") > 0 && $full_path !== $old ['path']) || $this->url_blacklist ($data ['path']) == FALSE) {                                  
                $mes ['count'] = 1;
                $mes [] = 'Раздел с указанным URL уже существует<br />или URL находится в списке запрещенных.<br />Пожалуйста, введите уникальный путь!';
                $this->session->set_flashdata ($mes);     
                redirect ('admin/pages/page_edit/'.$id);                       
            } else { 
                unset ($data ['p_path']);
                $data ['path'] = $full_path;
                  
                // Если загружено изображение              
                if ($_FILES ['pageimg']['size'] > 0) { 
                    $page_img = $_FILES ['pageimg']['name'];
                    $this->load->library ('lib_check_ext');                          
                    $whitelist = array ('.jpg', '.jpeg', '.png', '.gif');   // Задаем список допустимых расширений  
                        
                    // Цикл проверки на допустимые расширения         
                    if ($this->lib_check_ext->valid_ext ($whitelist, $page_img) == FALSE) {         
                        $mes ['count'] = 1; 
                        $mes [] = 'Файл не выбран или имеет формат, отличный от JPG/JPEG/PNG/GIF!';           
                        $this->session->set_flashdata ($mes);            
                        redirect ("admin/pages/page_edit/$id");
                    }
                    
                    // Загружаем изображение     
                    $extension = strtolower (end(explode (".", $page_img)));      // Расщирение изображения  
                    $cur = $id.".".$extension;    // Имя нового файла 
                    $uploaddir = "img/page/";     // Папка загрузки
                    
                    // Если файл уже загружен - удаляем   
                    foreach ($whitelist as $ext) {
                        $p_img = "img/page/".$id.$ext;
                        if (is_file ($p_img)) { @unlink ($p_img); }
                    }

                    $this->load->library ('lib_image');

                    if (move_uploaded_file ($_FILES['pageimg']['tmp_name'], $uploaddir . $cur)) {                      
                        $source_image = 'img/page/'.$cur;
                        $mini_image = 'img/page/mini/'.$cur;   
                        $this->lib_image->load ($source_image);     // Загрузка изображения 
                        
                        // Большое изображение для раздела
                        $this->lib_image->resize_crop ("200", "150")->save ($source_image, $overwrite=TRUE); 
                        
                        // Миниатюра для админки    
                        $this->lib_image->resize ("50", "50")->save ($mini_image, $overwrite=TRUE);                                                                        
                    } else {
                        $mes ['count'] = 1;        
                        $mes [] = 'При загрузке изображения возникли ошибки:<br />'.$_FILES['pageimg']['error'];
                        $this->session->set_flashdata ($mes);     
                        return FALSE;   
                    }                          
                }  
 
        		$this->db->update ("menu", $data, "id = $id");
                
                // Проверим, изменился ли путь относительно старого и если да, то меняем все соответствующие вхождения у потомков               
                $new_path = $this->input->post ('path');  // новый путь
                              
                if ($old ['level'] > 1) {          
                    $prep = explode ('/', $old ['path']); $old_path = array_pop ($prep);          
                } else {            
                    $old_path = $old ['path'];  
                }
                
                // Если url раздела изменился
                if ($new_path != $old_path) {
                  
                    // Возвращаем старый путь (до изменений)
                    $full_old_path = ($this->input->post ('p_path') != '')? $this->input->post ('p_path').'/'.$old_path : $old_path;
                    // Выбираем все поля, path которых начинается с $full_path 
                    $path_qr = $this->db->select ("id, path")->from ("menu")->like ("path", $full_old_path, "after")->where ("id !=", $id)->get ();
                    $path_res = $path_qr->result_array ();
                    
                    // И заменяем во всех найденных полях вхождение $old_path на $new_path
                    if (!empty ($path_res)) {
                        foreach ($path_res as $section) {
                            $r_path = $this->str_replace_once ($old_path, $new_path, $section ['path']);  
                            $upd_id = $section ['id'];
                            $this->db->update ("menu", array ("path" => $r_path), "id = $upd_id");   
                        } 
                    }                             
                }                                       
                return TRUE;                            
            }                        			
		} else { 		
			return FALSE;  			
		}		
    }
    
    // Удаление изображения раздела
    public function page_img_del ($id) {
        $extension = array ('.jpg', '.jpeg', '.png', '.gif');      
        foreach ($extension as $ext) {
            $p_img = "img/page/".$id.$ext;
            $mini_img = "img/page/mini/".$id.$ext;
            if (is_file ($p_img)) { 
                @unlink ($p_img);
                @unlink ($mini_img);                
                return TRUE;
            }
        }
        return FALSE;                  
    }
    
    // Удаление раздела
    public function del_page ($id) {  
       
        // $id = page_id
        $qr = $this->db->get_where ("menu", array ("parent_id" => $id));
        $res = $qr->result_array ();              

        // Узнаем, есть ли подразделы для раздела с данным id
        if (empty ($res)) {   // Если подразделов нет
            $qr = $this->db->get_where ("menu", array ("id" => $id));
            $res = $qr->row_array ();
            $arr = unserialize ($res ['modules']);
            
            // Проверяем наличие модулей в разделе
            if (!empty ($arr)) {      
                // Нашлись модули
                $mes ['count'] = 1;
                $mes [] = 'Нельзя удалять раздел, содержащий<br /> хотя бы один модуль!';
                $this->session->set_flashdata ($mes);  
                return FALSE; 
            } else {      
                // Модулей и подразделов нет - удаляем раздел
                $this->db->delete ("menu", "id = $id");
                // Пересортировка
                tree::resort ('menu', 'parent_id', $res ['parent_id']);          
                return TRUE;          
            }                  
        } else {   // Нашлись подразделы       
            $mes ['count'] = 1;
            $mes [] = 'Нельзя удалять раздел, имеющий подразделы!';
            $this->session->set_flashdata ($mes);             
            return FALSE;                 
        }            	  
    }
      
    // Добавление модуля
    public function add_module ($id, $module) {  
          
        $qr = $this->db->get_where ("menu", array ("id" => $id));
        $res = $qr->row_array ();

        $this->db->insert ($module, array ('menu_id' => $id));   // Добавляем в таблицу с модулем значение menu_id
        $last_key = 1; 
        
        if (empty ($res ['modules']) || $res ['modules'] == 'null' ) {   // Если массив пуст или модулей нет           
            $mod = array ();   // Массив пустой                 
        } else { 
            // Если уже есть массив с модулем - добавляем новый элемент в массив    
            $mod = unserialize ($res ['modules']);            
            foreach ($mod as $number => $each) {
                if ($number > $last_key) {$last_key = $number;}
                if ($number = $last_key) {$last_key = $number + 1;}     
            }           
        }
        
        $mod [$last_key]['module_id'] = $this->db->insert_id ();  // ID последнего добавленного модуля 
        $mod [$last_key]['name'] = $module; // Имя модуля
        $mod [$last_key]['menu_id'] = $id;  // ID раздела, к которому привязан модуль
                
        $mod_data = array ();
        $mod_data ['modules'] = serialize ($mod);     // Создаем массив для записи в базу
        $this->db->update ("menu", $mod_data, "id = $id");        // Обновляем ячейку с модулем в базе    
                              
        switch ($module) {
            case 'articles' : $mod_mes = 'Новая статья добавлена!'; break;
            case 'blog' : $mod_mes = 'Новая запись блога добавлена!'; break;
            case 'gallery_list' : $mod_mes = 'Новая галерея добавлена!'; break;
            case 'feedback_list' : $mod_mes = 'Новый блок отзывов добавлен!'; break;
            case 'faq_list' : $mod_mes = 'Новый блок \'Вопрос-ответ\' добавлен!'; break;
            case 'news_list' : $mod_mes = 'Новая новостная лента добавлена!'; break;
        }                       
        $mes ['count'] = 1; 
        $mes [] = $mod_mes;
        $this->session->set_flashdata ($mes);
        redirect ('admin/pages/page_edit/'.$id);              
    }
    
    // Редактирование модуля
    public function edit_module ($module_id, $module, $id) {  
          
        $validation_rules = 'edit_'.$module.'_rules';        
    	$this->form_validation->set_rules ($this->$validation_rules);
		
		if ($this->form_validation->run ()) {          
        	$data = array ();			
			foreach ($this->$validation_rules as $one) {				
				$f = $one ['field'];
				$data [$f] = $this->input->post ($f);
			} 
            
            // Формируем path для страницы блога
            if ($module == "blog") {
                if ($data ['path'] == "") {
                    $this->load->library ('lib_transliteration');
                    $data ['path'] = $this->lib_transliteration->translite ($data ['title']);   
                }
			    
                // Проверка на уникальность path
                $qr = $this->db->select ("path")->from ("blog")->where ("id", $module_id)->get ();
                $old = $qr->row_array (); 
                
                $this->db->where ("path", $data ['path']);
                                    
                if (($this->db->count_all_results ("blog") > 0 && $data ['path'] !== $old ['path']) || $this->url_blacklist ($data ['path']) == FALSE) {                                  
                    $mes ['count'] = 1;
                    $mes [] = 'Запись с указанным URL уже существует<br />или URL находится в списке запрещенных.<br />Пожалуйста, введите уникальный путь!';
                    $this->session->set_flashdata ($mes);     
                    redirect ('admin/pages/page_edit/'.$id);                       
                }
                                
                $data ['date'] = ($data ['date'] == "")? date ("Y-m-d") : mdl_date::olddate ($data ['date'], ".");                 
            }
                       
            // Обновляем таблицу с модулем
            $this->db->update ($module, $data, "id = $module_id");             
            return TRUE;            
        } else {         
            return FALSE;                
        }
    }
    
    // Удаление модуля
    public function delete_module ($id, $module, $number, $module_id) {  
   
        // Если галерея - проверяем, нет ли в ней изображений
        if ($module == "gallery_list") { 
            $this->db->where ("gallery_id", $module_id);  
            if ($this->db->count_all_results ("gallery") > 0) {            
                $mes ['count'] = 1;        
                $mes [] = 'Нельзя удалять галерею, пока в ней есть хотя бы одно изображение!';
                $this->session->set_flashdata ($mes);                                             
                redirect ('admin/pages/page_edit/'.$id);                 
            } else {            
                @rmdir ('img/gallery/'.$module_id); // Изображений в галерее нет - удаляем пустую папку                 
            }    
        }
        
        // Если отзывы - проверяем, нет ли самих отзывов в блоке
        if ($module == "feedback_list") {
            $this->db->where ("parent_id", $module_id);                     
            if ($this->db->count_all_results ("feedback") > 0) {                          
                $mes ['count'] = 1;        
                $mes [] = 'Нельзя удалять блок отзывов, пока в нем есть хотя бы одна запись!';
                $this->session->set_flashdata ($mes);                                              
                redirect ('admin/pages/page_edit/'.$id);                
            }                        
        }
        
        // Если Вопросы-ответы - проверяем, нет ли самих вопросов-ответов в блоке
        if ($module == "faq_list") {
            $this->db->where ("parent_id", $module_id);    
            if ($this->db->count_all_results ("faq") > 0) {                           
                $mes ['count'] = 1;        
                $mes [] = 'Нельзя удалять блок вопросов-ответов, пока в нем есть хотя бы одна запись!';
                $this->session->set_flashdata ($mes);                                              
                redirect ('admin/pages/page_edit/'.$id);                
            }                        
        }
        
        // Если Новости - проверяем, нет ли самих новостей в блоке
        if ($module == "news_list") {
            $this->db->where ("parent_id", $module_id);            
            if ($this->db->count_all_results("news") > 0) {                           
                $mes ['count'] = 1;        
                $mes [] = 'Нельзя удалять новостную ленту, пока в ней есть хотя бы одна новость!';
                $this->session->set_flashdata ($mes);                                              
                redirect ('admin/pages/page_edit/'.$id);                
            }                        
        }        
        
        // Удаляем запись о модуле из таблицы с модулем
        $this->db->delete ($module, "id = $module_id");  
                
        // Чистим массив с модулями в таблице menu => удаляем оттуда запись о модуле
        $qr = $this->db->get_where ("menu", "id = $id");
        $res = $qr->row_array ();
        
        $modules = unserialize ($res ['modules']);  
        unset ($modules [$number]);
        $data = array ('modules' => serialize ($modules));
        
        $this->db->update ("menu", $data, "id = $id");
        
        $mes ['count'] = 1;        
        switch ($module) {
            case 'articles' : $mod_mes = 'Статья удалена!'; break;
            case 'blog' : $mod_mes = 'Запись блога удалена!'; break;
            case 'gallery_list' : $mod_mes = 'Галерея удалена!'; break;
            case 'feedback_list' : $mod_mes = 'Блок отзывов удален!'; break;
            case 'faq_list' : $mod_mes = 'Блок вопросов-ответов удален!'; break;
            case 'news_list' : $mod_mes = 'Новостная лента удалена!'; break;
        }          
        $mes [] = $mod_mes;
        $this->session->set_flashdata ($mes); 
        redirect ('admin/pages/page_edit/'.$id);         
    }
    
    // Получение данных из модуля
    public function get_modules ($table_name, $id) {  // Из таблицы с модулем с нужным id             
        $qr = $this->db->get_where ($table_name, "id = $id");       
        return $qr->row_array ();  
    }
    
    // Получение данных из таблиц
    public function getElements ($m) { 
          
        $table = $m ['table'];
        
        if (isset ($m ['where'])) {             
            $m []  = 'yes';
            $where = $m ['where'];
                        
            foreach ($where as $key => $value) {
                $param1 = $key;
                $param2 = $value;  
            }                         
            $this->db->where ($param1, $param2);  
        }
        
        if (isset ($m ['order'])) {        
            $order = $m ['order']; 
                       
            if (!isset ($order ['dir'])) {            
                $by = $order ['by'];
                $this->db->order_by ($by);                    
            } else { 
                $by = $order ['by'];
                $dir = $order ['dir'];
                $this->db->order_by ($by, $dir);                 
            }
        }
        
        if (isset ($m ['limit'])) {           
            $limit = $m ['limit'];            
            $num = $limit ['num'];
            
            if (isset ($limit ['from'])) {                 
                $from = $limit ['from']; 
                $this->db->limit ($num, $from);                     
            } else {                        
                $this->db->limit ($num);                 
            }
        } 
        
        $res = $this->db->get ($table); 
        return $res->result_array ();                     
    }
        
	// Отображение странички в админке
	public function admin_page ($path, $data = array (), $page_title = '') {  
        $data ['page_title'] = $page_title;
        $data ['validation_errors'] = validation_errors ();
        $this->load->view ('admin/'.$path, $data);        			
	}
	
	// Отображение странички на сайте
	public function user_page ($path) {	
 
        $query = $this->db->select ("*")->from ("menu")->where ("path", $path)->get ();       
        $data = $query->row_array ();           
        
		if ($query->num_rows () > 0) {        
			$data = $query->row_array ();                       			
            if ($data ['showed'] != 1) {             
				die ("Эта страничка скрыта<br /><br /><a href='/'>вернуться на сайт</a>");                  
			}                    			
		} else {
            die ("Такой страницы не существует");
        }
               
        // Показываем страничку сайта
		$this->load->view ('index', $data);         			
	}
    
	// Отображение записи блога  - ПЕРЕДЕЛАТЬ ИЛИ УДАЛИТЬ МОДУЛЬ БЛОГА
	public function blog_page ($path) { 		
        $query = $this->db->get_where ("blog", "path = \"$path\""); 
        if ($query->num_rows () > 0) {  
			$data = $query->row_array ();
        }       	   			
        $this->load->view ('templates/modules/blog/blog_show', $data);             				
	}
    
	// Отображение страницы новости
	public function news_page ($path) { 		
        $query = $this->db->get_where ("news", "path = \"$path\""); 
        if ($query->num_rows () > 0) {  
			$data = $query->row_array ();
        }       	   			
        $this->load->view ('index', $data);             				
	}    
    
    // Функция замены первого вхождения у строки
    public function str_replace_once ($search, $replace, $text) {        
        $pos = strpos ($text, $search);                
        return ($pos !== FALSE)? substr_replace ($text, $replace, $pos, strlen ($search)) : $text;               
    }
    
    // URL blacklist - если нашлись совпадения возвращает FALSE
    public function url_blacklist ($url) { 
        $count = 0;  // Счетчик совпадений 
        $url_blacklist = unserialize ($this->config->item ('url_blacklist'));                
        foreach ($url_blacklist as $one) {if ($url == $one) {$count = $count + 1;}}     
        return ($count != 0)? FALSE : TRUE;               
    }
    
    public function randnum ($min, $max, $count) {
    	$random = array (); 
    	$tmp = array ();   
 	  
    	for ($i = 0; $i < $count; $i++) {
    	    do {
    	        $a = rand ($min, $max);
    	    } while (
                isset ($tmp [$a])
            ); 
            $tmp [$a] = 1;
    	    $random [] = $a;
    	} 
    	unset ($tmp);
    	return $random;
    }     
        	
}     
