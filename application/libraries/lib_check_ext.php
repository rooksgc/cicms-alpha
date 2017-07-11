<? // Библиотека для проверки загружаемых файлов

if (!defined ('BASEPATH')) exit ('BASEPATH UNDEFINED');

class Lib_check_ext {

    // Функция проверяет расширения одного файла
    public function valid_ext ($whitelist, $file) { 
    
        $is_yes = 0;           
        foreach ($whitelist as $ext) {
            if (preg_match ("/$ext\$/i", $file)) {
                $is_yes = $is_yes + 1; 
            }    
        } 
        if ($is_yes == 0) {return FALSE;}
            
        return TRUE;         
    }

    // Функция проверяет расширения файлов в массиве
    public function valid_ext_array ($whitelist, $fileslist) { 
    
        foreach ($fileslist as $fls) {
            $is_yes = 0;           
            foreach ($whitelist as $ext) {
                if (preg_match ("/$ext\$/i", $fls)) {
                    $is_yes = $is_yes + 1; 
                }    
            } 
            if ($is_yes == 0) {return FALSE;}
        } 
        return TRUE;         
    }
    
  
}