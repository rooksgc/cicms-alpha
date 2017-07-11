<? // Модель для вывода данных из БД

if (!defined ('BASEPATH')) exit ('basepath undefined');

class View extends CI_Model {    
    
	public function __construct () {
    	parent:: __construct (); 
	}

    /* --- Функции получают все данные и возвращают массив --- */
    
    // Получаем все данные из одной статьи по id и возвращаем массив
    public function Article ($id) {         
        $qr = $this->db->get_where ("articles", "id = $id");
        return $qr->row_array ();
    }

    /* --- Функции получают одно поле и возвращают его значение --- */

    // Получаем текст кастомной вставки по коду alias
    public function IncludeText ($alias) {         
        $qr = $this->db->select ("text")->from ("includes")->where ("alias", $alias)->get ();
        $res = $qr->row_array ();
        return $res["text"];
    }
      
          
}