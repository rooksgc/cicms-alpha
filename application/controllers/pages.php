<? // Контроллер отображения страниц

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Pages extends CI_Controller {

    function __construct () {
        parent:: __construct ();
    }
    
    // Отображение главной страницы 
    public function index () {    
        crud::user_page ('index');    
    }
    
    // Отображение страницы с указанным $path   
    public function show () {    
        $path = substr ($this->uri->uri_string (), 1);
        $last_segment = $this->uri->segment ($this->uri->total_segments ());        
        if (is_numeric ($last_segment)) {          
            $len = strlen ($last_segment) + 1;
            $path = substr ($path, 0, -$len);    
        }
        crud::user_page ($path);       
    }
    
    // Отображение страницы блога
    public function blog_page ($path) {                
        crud::blog_page ($path);    
    }
    
    // Отображение страницы новости
    public function news_page ($path) {                
        crud::news_page ($path);    
    }    
      
}