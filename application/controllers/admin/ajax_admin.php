<? // Контроллер Ajax для админки

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Ajax_admin extends CI_Controller {

    function __construct () {
        parent:: __construct ();
        $this->lib_auth->check_admin ();
    }   
    
    // Сортировка модулей в админке
    public function modules_sort () {
    
        $page_id = $this->input->post ('pageid') + 0; 
        
        $qr = $this->db->select ("modules")->from ("menu")->where ("id", $page_id)->get ();
        $res = $qr->row_array ();  // Достаем массив с текущей сортировкой
        $o_sort = unserialize ($res ['modules']); 
        
        $c = 1;  // Объявляем начало счетчика сортировки
        $sort = array ();  // Будущий отсортированный массив
        
        foreach ($this->input->post ('mitems') as $i) {
            $sort [$c] = $o_sort [$i];
            $c = $c + 1;                    
        }  

        $res_arr = serialize ($sort);        
        $this->db->update ("menu", array ("modules" => $res_arr), "id = $page_id");  
    }
    
    // Сортировка изображений в галерее
    public function gallery_sort () {                 
        $pos = 0;        
        foreach ($this->input->post ('items') as $item) {               
            $this->db->update ("gallery", array ("sort" => $pos), "id = $item");             
            $pos = $pos + 1;   
        }
    }
    
    // Сортировка разделов меню
    public function menu_sort () {
        $pos = 0;        
        foreach ($this->input->post ('items') as $item) {               
            $this->db->update ("menu", array ("sort" => $pos), "id = $item");             
            $pos = $pos + 1;   
        }        
    }     
    
}