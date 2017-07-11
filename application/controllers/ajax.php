<? // Контроллер Ajax для страниц сайта

if (!defined('BASEPATH')) exit('basepath undefined');

class Ajax extends CI_Controller {
    
    function __construct() {
        parent:: __construct();
    }    
        
    // Отправка form1
 	public function form1_send() {
       
	    // Правила валидации
        $form1_rules = array(
            array(
    			'field'	=> 'tel',
    			'label'	=> '\'Телефон\'',
    			'rules' => 'trim|required|no_special_symbols|not[Телефон]'				
    		),            
            array(
    			'field'	=> 'name',
    			'label'	=> '\'ФИО\'',
    			'rules' => 'trim|required|no_special_symbols|not[ФИО]'				
    		)
        );
               
        $this->form_validation->set_rules($form1_rules);
          
        if ($this->form_validation->run()) { 		
			$data = array();	
			foreach ($form1_rules as $one) {				
				$f = $one['field'];
				$data[$f] = $this->input->post($f);
			}
            
            $name = $data['name'];
            $tel = $data['tel']; 
            
            // Кому / От кого
            $to = $this->config->item("email");
            $from = $this->config->item("donotreply_email"); 
            
            // Тема subject
            $subject = "Заявка на обратный звонок с сайта";
            $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
        
        	$header = "MIME-Version: 1.0\r\n"; 
    		$header.= "From: ".$from."\r\n";
    		$header.= "Subject: ".$subject."\r\n";
    		$header.= "Content-type: text/plain; charset=utf-8\r\n";
    
            // Сообщение
            $message = "На сайте подана заявка на звонок. Данные клиента:\r\n\r\nИмя: $name \r\nТелефон: $tel";            
            
            // Отправка
            @mail($to, $subject, $message, $header);  
            $resp = "Заявка на звонок отправлена!";
                                
            if ($this->input->is_ajax_request()) echo $resp;?> 
            <script>
                $(document).ready(function() {
                    $(".form1_input_tel").val("Телефон");
                    $(".form1_input_name").val("ФИО");
                });
            </script>      
            <? exit;                  
        } else {
            if ($this->input->is_ajax_request()) echo validation_errors(); exit;
        }
    } 
    
    // Отправка form2
 	public function form2_send() {
       
	    // Правила валидации
        $form2_rules = array(
            array(
    			'field'	=> 'tel',
    			'label'	=> '\'Телефон\'',
    			'rules' => 'trim|required|no_special_symbols|not[Телефон]'				
    		),            
            array(
    			'field'	=> 'name',
    			'label'	=> '\'ФИО\'',
    			'rules' => 'trim|required|no_special_symbols|not[ФИО]'				
    		),
            array(
    			'field'	=> 'text',
    			'label'	=> '\'Ваше сообщение\'',
    			'rules' => 'required|not[Ваше сообщение]'				
    		)
        );
               
        $this->form_validation->set_rules($form2_rules);
          
        if ($this->form_validation->run()) { 		
			$data = array();	
			foreach ($form2_rules as $one) {				
				$f = $one['field'];
				$data[$f] = $this->input->post($f);
			}
            
            $name = $data['name'];
            $tel = $data['tel'];             
            //$text = ($data['text'] == "Ваше сообщение")? "отсутствует." : $data['text'];
            $text = $data['text'];
            
            // Кому / от кого
            $to = $this->config->item("email");
            $from = $this->config->item("donotreply_email"); 
            
            // Тема subject
            $subject = "Пришло письмо с сайта";
            $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
        
        	$header = "MIME-Version: 1.0\r\n"; 
    		$header.= "From: ".$from."\r\n";
    		$header.= "Subject: ".$subject."\r\n";
    		$header.= "Content-type: text/plain; charset=utf-8\r\n";
    
            // Сообщение
            $message = "На сайте написано новое письмо. Данные отправителя:\r\n\r\nИмя: $name \r\nТелефон: $tel \r\nТекст письма: $text";            
            
            // Отправка
            @mail($to, $subject, $message, $header);  
            $resp = "Ваше письмо успешно отправлено!"; 
            
            if ($this->input->is_ajax_request()) echo $resp;?> 
            <script type="text/javascript">
                $(document).ready (function() {
                    $(".form2_input_tel").val("Телефон");
                    $(".form2_input_name").val("ФИО");
                    $("textarea.form2_text").val("Ваше сообщение");
                });
            </script>      
            <? exit;                  
        } else {
            if ($this->input->is_ajax_request()) echo validation_errors(); exit;
        }          
    }  
    
    // Отправка form3
 	public function form3_send() {

        // Сначала проверяем капчу
        if ($this->lib_captcha->check($this->input->post("captchacode"))) {
        
            // Правила валидации
            $form3_rules = array(
                array(
        			'field'	=> 'tel',
        			'label'	=> '\'Телефон\'',
        			'rules' => 'trim|required|no_special_symbols|not[Телефон]'				
        		),            
                array(
        			'field'	=> 'name',
        			'label'	=> '\'ФИО\'',
        			'rules' => 'trim|required|no_special_symbols|not[ФИО]'				
        		),
                array(
        			'field'	=> 'text',
        			'label'	=> '\'Написать сообщение\'',
        			'rules' => 'not[Написать сообщение]'				
        		)
            );
                   
            $this->form_validation->set_rules($form3_rules);
              
            if ($this->form_validation->run()) { 		
    			$data = array();	
    			foreach ($form3_rules as $one) {				
    				$f = $one['field'];
    				$data[$f] = $this->input->post($f);
    			}
                
                $name = $data['name'];
                $tel = $data['tel'];             
                $text = ($data['text'] == "Написать сообщение")? "отсутствует." : $data['text'];
                
                // Кому / от кого
                $to = $this->config->item("email");
                $from = $this->config->item("donotreply_email"); 
                
                // Тема subject
                $subject = "На сайте отправлено сообщение из контактной формы";
                $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
            
            	$header = "MIME-Version: 1.0\r\n"; 
        		$header.= "From: ".$from."\r\n";
        		$header.= "Subject: ".$subject."\r\n";
        		$header.= "Content-type: text/plain; charset=utf-8\r\n";
        
                // Сообщение
                $message = "На сайте оставлено новое сообщение следующего содержания:\r\n\r\nИмя: $name \r\nТелефон: $tel \r\nСообщение: $text";            
                
                // Отправка
                @mail($to, $subject, $message, $header);  
                $resp = "Ваше сообщение отправлено! Мы обязательно свяжемся с Вами!"; 
                
                if ($this->input->is_ajax_request()) echo $resp;?> 
                <script type="text/javascript">
                    $(document).ready (function() {
                        $(".form3_input_name").val("ФИО");
                        $(".form3_input_tel").val("Телефон");
                        $("textarea.form3_text").val("Написать сообщение");
                    });
                </script>      
                <? exit;                  
            } else {
                if ($this->input->is_ajax_request()) echo validation_errors(); exit;
            }        
       
        } else { 
            if ($this->input->is_ajax_request())  echo "Неверный код с картинки!"; exit;  
        }     
	              
    }      


    // Отправка кастомной формы 
 	public function order_form_send() {

        // Сначала проверяем капчу (капчи нет)
        /* if ($this->lib_captcha->check($this->input->post("captchacode"))) { */
        
            // Правила валидации
            $order_form_rules = array(         /* required| */
                array(
        			'field'	=> 'org',
        			'label'	=> '\'Организация\'',
        			'rules' => 'trim|required|no_special_symbols|not[Организация]'				
        		),            
                array(
        			'field'	=> 'lico',
        			'label'	=> '\'Контактное лицо\'',
        			'rules' => 'trim|required|no_special_symbols|not[Контактное лицо]'				
        		),
                array(
        			'field'	=> 'tel',
        			'label'	=> '\'Телефон для связи\'',
        			'rules' => 'trim|required|not[Телефон для связи]'				
        		),
                array(
        			'field'	=> 'email',
        			'label'	=> '\'E-mail\'',
        			'rules' => 'trim|required|not[E-mail]'				
        		),
                array(
        			'field'	=> 'info',
        			'label'	=> '\'Информация об изделии\'',
        			'rules' => 'trim|required|no_special_symbols|not[Банер, постер или др.]'				
        		),
                array(
        			'field'	=> 'srok',
        			'label'	=> '\'Желаемый срок получения\'',
        			'rules' => 'trim|required|not[Желаемый срок получения]'				
        		),
                array(
        			'field'	=> 'after',
        			'label'	=> '\'Послепечатная обработка\'',
        			'rules' => 'trim|no_special_symbols'				
        		),
                array(
        			'field'	=> 'link',
        			'label'	=> '\'Ссылка на скачивание файла\'',
        			'rules' => ''				
        		),
                array(
        			'field'	=> 'dop',
        			'label'	=> '\'Примечание к заказу\'',
        			'rules' => 'trim|no_special_symbols'				
        		)
            );
                   
            $this->form_validation->set_rules($order_form_rules);
              
            if ($this->form_validation->run()) { 		
    			$data = array();	
    			foreach ($order_form_rules as $one) {				
    				$f = $one['field'];
    				$data[$f] = $this->input->post($f);
    			}
                
                // Формируем переменные для письма 
                $org = $data['org'];
                $lico = $data['lico'];                
                $tel = $data['tel'];            
                $email = $data['email']; 
                $info = $data['info'];
                $srok = $data['srok'];                
                $after = ($data['after'] !== "Например: резка, установка люверсов, проклейка карманов")? $data['after'] : "не требуется";     
                $link = $data['link'];
                $dop = ($data['dop'] !== "")? $data['dop'] : "отсутствует";
                
                switch ($_POST["type"]) {
                    case "0" : $type = "Широкоформатная печать"; break;
                    case "1" : $type = "Интерьерная печать"; break;
                }
                
                switch ($_POST["material"]) {
                    case "ban320" : $material = "Баннер 320 гр."; break;
                    case "ban440" : $material = "Баннер 440 гр."; break;
                    case "ban510" : $material = "Баннер 510 гр."; break;
                    case "setka380" : $material = "Сетка 380 гр."; break;
                    case "sam_mate" : $material = "Самоклейка белая матовая"; break;
                    case "sam_glossy" : $material = "Самоклейка белая глянцевая"; break;
                    case "blueback" : $material = "Бумага BlueBack"; break;
                    case "poster" : $material = "Бумага постерная"; break;
                    case "glossy220" : $material = "Фотобумага глянцевая 220 гр."; break;
                    case "holst" : $material = "Холст"; break;
                }
                
                switch ($_POST["kachestvo"]) {
                    case "360" : $kachestvo = "360 dpi"; break;
                    case "720" : $kachestvo = "720 dpi"; break;
                    case "1440" : $kachestvo = "1440 dpi"; break;
                }
                
                switch ($_POST["lam"]) {
                    case "no" : $lam = "Без ламинации"; break;
                    case "mate" : $lam = "Матовая"; break;
                    case "glossy" : $lam = "Глянцевая"; break;
                }
                
                switch ($_POST["file"]) {
                    case "0" : $file = "отправлю на e-mail"; break;
                    case "1" : $file = "Ссылка на скачивание файла"; break;
                }
                
                $link = ($_POST["file"] == 1)? trim($_POST["link"]) : ""; 
                
                if($_POST["file"] == 1 && $link !== "") {
                    $file = "cсылка на скачивание файла ".$link;     
                }
                
                if($_POST["file"] == 1 && $link == "") {
                    if ($this->input->is_ajax_request()) echo "Поле со ссылкой на файл не должно быть пустым"; 
                    exit;   
                }
                
                //$text = ($data['text'] == "Написать сообщение")? "отсутствует." : $data['text'];
                
                // Кому / от кого
                $to = $this->config->item("email");
                $from = $this->config->item("donotreply_email"); 
                
                // Тема subject
                $subject = "На сайте заполнена форма заказа";
                $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
            
            	$header = "MIME-Version: 1.0\r\n"; 
        		$header.= "From: ".$from."\r\n";
        		$header.= "Subject: ".$subject."\r\n";
        		$header.= "Content-type: text/plain; charset=utf-8\r\n";
        
                // Сообщение
                $message = "На сайте заполнена форма заказа:\r\n\r\n
                --------------------\r\n
                Организация: $org \r\n
                Контактное лицо: $lico \r\n
                Телефон для связи: $tel \r\n
                E-mail: $email \r\n
                Информация об изделии: $info \r\n
                Желаемый срок получения: $srok \r\n
                --------------------\r\n
                Тип печати: $type \r\n
                Материал: $material \r\n
                Качество: $kachestvo \r\n
                Ламинация: $lam \r\n
                Послепечатная обработка: $after \r\n
                Файл с макетом: $file \r\n
                --------------------\r\n
                Примечание к заказу: $dop \r\n";            
                
                // Отправка
                @mail($to, $subject, $message, $header);  
                $resp = "Ваша заявка отправлена! Мы свяжемся с Вами в ближайшее время!"; 
                
                if ($this->input->is_ajax_request()) echo $resp;?> 
                <script type="text/javascript">
                    $(document).ready (function() {
                        $(".org").val("Организация");
                        $(".lico").val("Контактное лицо");
                        $(".tel").val("Телефон для связи");
                        $(".email").val("E-mail"); 
                        $(".info").val("Банер, постер или др.");
                        $(".srok").val("Желаемый срок получения");
                        $(".after").val("Например: резка, установка люверсов, проклейка карманов");
                        $(".flink").val("");
                        $(".dop").val("");
                    });
                </script>      
                <? exit;                  
            } else {
                if ($this->input->is_ajax_request()) echo validation_errors(); exit;
            }        
       
       /* } else { 
            if ($this->input->is_ajax_request())  echo "Неверный код с картинки!"; exit;  
        } */    
	              
    }



    // Получение данных из базы по ajax-запросу
    public function ajax_get() {
        // Получаем данные post
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        
        $qr = $this->db->select($field)->from($table)->where("id = $id")->get();
        $data = $qr->row_array();
        
        // Ответ Ajax
        if ($this->input->is_ajax_request()) echo $data[$field]; exit; 
    } 

    // Показываем картинку для капчи
    public function captha_img() {
        echo $this->lib_captcha->image();
    }    

    // Обработка запросов отзывов для формы с сайта
    public function feedback_add() {
        
        $this->load->model('mdl_feedback_list');
        $this->load->model('mdl_feedback_list_validate');      
        
        // Сначала проверяем капчу
        if ($this->lib_captcha->check($this->input->post('captchacode'))) {  
         
             // Добавление отзыва       
            $id = $this->input->post('id');
            $author = $this->input->post('author');
            $email = ($this->input->post('email') !== "")? $this->input->post('email') : "не указан";
            $date = $this->input->post('date');
            $text = $this->input->post('text');
            $parent_id = $this->input->post('parent_id');
            $is_ajax = $this->input->post('is_ajax');
            
            // Обработка
            if ($this->mdl_feedback_list_validate->feedback_add($author, $date, $email, $text, $is_ajax) !== FALSE) {
            
                $resp = "Ваш отзыв успешно отправлен!";
                    
                 // Отправка оповещения о наличии отзыва на e-mail 
                $to = $this->config->item('faq_global_email');
                $from = $this->config->item("donotreply_email");      
                // Тема
                $subject = "На сайте написан новый отзыв";
                $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';  
                // Заголовки
                $header = "MIME-Version: 1.0\r\n"; 
                $header.= "From: ".$from."\r\n";
                $header.= "Subject: ".$subject."\r\n";
                $header.= "Content-type: text/plain; charset=utf-8\r\n";
                // Сообщение
                $message = "Отзыв от: $author | $date | e-mail: $email\r\nТекст отзыва: $text\r\n";
                // Отправка 
                @mail($to, $subject, $message, $header);               
                 
            } else { $resp =  validation_errors(); }                          

            // Сброс текстовых полей
            if ($this->input->is_ajax_request()) { echo $resp; 
            ?><script type="text/javascript">
                $(document).ready (function() {
                    var rand = Math.round (Math.random() * 999);
                    $(".feedback_add").find(".captcha").attr("src", "/ajax/captha_img/"+rand);
                    $(".feedback_add").find(".captcha_code").val(""); 
                    $(".feedback_add").find(".feedback_text").val("");
                });
            </script><?
            exit; } 
                                  
        } else { 
            if ($this->input->is_ajax_request())  echo 'Неверный код с картинки!'; exit;  
        }
    }

    // Обработка вопросов с сайта
    public function faq_add() {
        
        $this->load->model('mdl_faq_list');
        $this->load->model('mdl_faq_list_validate');      
        
        // Сначала проверяем капчу
        if ($this->lib_captcha->check($this->input->post('captchacode'))) {  
         
             // Добавление вопроса      
            $id = $this->input->post('id');
            $parent_id = $this->input->post('parent_id');
            $author = $this->input->post('author');
            $email = $this->input->post('email');
            $date = $this->input->post('date');
            $question = $this->input->post('question');
                           
            if ($this->mdl_faq_list_validate->faq_add($author, $date, $email, $question, NULL) !== FALSE) { 
               
                $resp = 'Ваш Вопрос отправлен на модерацию. Мы дадим на него ответ и опубликуем!';
                
                if ($this->input->post('email_notice') !== "") {
                    $to = $this->input->post('email_notice');    
                } elseif ($this->config->item('faq_global_email') !== "") { 
                    $to = $this->config->item('faq_global_email'); 
                } 

                if (isset($to)) { 
                    // Отправитель
                    $from = $this->config->item("donotreply_email");
                    
                    // Тема
                    $subject = "На сайте задан новый вопрос";
                    $subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
                
                    // Заголовки
                	$header = "MIME-Version: 1.0\r\n"; 
            		$header.= "From: ".$from."\r\n";
            		$header.= "Subject: ".$subject."\r\n";
            		$header.= "Content-type: text/plain; charset=utf-8\r\n";
            
                    // Сообщение
                    $message = "Вопрос от: $author | $date | e-mail: $email\r\nСодержание: $question\r\n";
            
                    // Отправка 
                    @mail($to, $subject, $message, $header);
                }   
                
            } else { $resp = validation_errors(); } 
            
            if ($this->input->is_ajax_request()) { echo $resp; 
            ?><script type="text/javascript">
                $(document).ready(function() {
                    var rand = Math.round (Math.random() * 999);
                    $(".faq<?=$parent_id?>").find(".captcha").attr("src", "/ajax/captha_img/"+rand);
                    $(".faq<?=$parent_id?>").find(".captcha_code").val("");
                });
            </script><?
            exit; } 
                                  
        } else { 
            if ($this->input->is_ajax_request())  echo 'Неверный код с картинки!'; exit;  
        }
    }
    
    
}