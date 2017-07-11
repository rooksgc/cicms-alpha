<? // Расширение класса валидации форм

if (!defined ('BASEPATH')) exit ('No direct script access allowed');

class MY_Form_Validation extends CI_Form_Validation {
	
    public function __construct () {
        parent:: __construct ();
	
	      // Загружаем новый языковый файл
        $CI = &get_instance ();
		    $CI->lang->load ('validation_new');
    } 

    // Проверка на конкретную строку
    public function not ($str, $param) {
        return ($str == $param) ? FALSE : TRUE;
    }    

    // Проверка на только числа или числовые строки
    public function not_numeric ($str) {
        return (is_numeric ($str))? FALSE : TRUE;
    }  

    // Валидация url (path)
    public function valid_path ($str) {
        return (!preg_match ("/^([a-z0-9\/_-])+$/i", $str)) ? FALSE : TRUE;
    }
        
    // Функция допускает только наличие маленьких английских букв, цифр и знаков _-
    public function az_numeric ($str) {
        return (!preg_match ("/^([a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
    }
    
    // Запрет на спецсимволы < > = [ ] { } | / $ ^ ~
    public function no_special_symbols ($str) {
        return (!preg_match ("/^([^\>\<\=\[\]\{\}\|\/\$\^\~\`])+$/i", $str)) ? FALSE : TRUE;
    }  
	
    // Валидация url
    public function valid_url ($str) {
        return (!preg_match ('/^(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:;.?+=&%@!\-\/]))?$/',$str)) ? FALSE : TRUE;
    }
    
	// Валидное название
    public function valid_title ($str) {
        return (!preg_match ('/^[А-Яа-яЁё\w\d\s\.\,\+\-\_\!\?\#\%\@\№\/\(\)\[\]\:\&\$\*]{1,250}$/',$str)) ? FALSE : TRUE;
    }       
	
	// Проверка на уникальность при добавлении в menu 
    public function uniq ($str, $param) {    
        $CI = &get_instance ();
        $CI->db->where ($param, $str);                     
        return ($CI->db->count_all_results ("menu") !== 0) ? FALSE : TRUE;
    }
    
	// Проверка на уникальность при добавлении в blog 
    public function uniq_blog ($str, $param) {    
        $CI = &get_instance ();
        $CI->db->where ($param, $str);                     
        return ($CI->db->count_all_results ("blog") !== 0) ? FALSE : TRUE;
    }    
    
    // Проверка на уникальность при добавлении в blog_categories 
    public function uniq_blog_category ($str, $param) {    
        $CI = &get_instance ();
        $CI->db->where ($param, $str);                     
        return ($CI->db->count_all_results ("blog_categories") !== 0) ? FALSE : TRUE;
    }
           	  		
}