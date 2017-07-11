<? // Модель для работы с файлами

if (!defined ('BASEPATH')) exit ('basepath undefined');

class File extends CI_Model {    
    
	public function __construct () {
    	parent:: __construct (); 
	}
    
    // Коррекция функции pathinfo для работы с кодировкой UTF-8 
    public function upathinfo ($path_file) {
        $path_file = strtr ($path_file, array('\\'=>'/'));
        
        preg_match ("~[^/]+$~", $path_file, $file);
        preg_match ("~([^/]+)[.$]+(.*)~", $path_file, $file_ext);
        preg_match ("~(.*)[/$]+~", $path_file, $dirname);
        
        return array (
            'dirname' => $dirname [1],
            'basename' => $file [0],
            'extension' => (isset ($file_ext [2]))? $file_ext [2] : false,
            'filename' => (isset ($file_ext [1]))? $file_ext [1] : $file [0]);
    }     
      
}