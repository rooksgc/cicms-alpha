<? // Библиотека проверки на совпадающие имена

if (!defined ('BASEPATH')) exit ('BASEPATH UNDEFINED');

class Lib_check_same_name {
    
    // Функция возвращает результат в случае совпадения с названием файла $filename из таблицы $table
    public function same_name ($filename, $row_name, $table) { 
        
        $CI = &get_instance ();
        $query = $CI->db->select ($row_name)->from ($table)->get ();
        $res = $query->result_array ();        
        
        $ppos = strrpos ($filename, '.');    // Отстыковываем расширение файла $filename
        $new_filename = substr ($filename, 0, $ppos);        // $filename без расширения  
        $new_filename = strtr ($new_filename, " ", "_");   // Заменяем пробелы в названии на символ _        
       
        foreach ($res as $in_name) {
            // Отстыковываем расширение файла из таблицы
            $ppos = strrpos ($in_name [$row_name], '.');
            $new_in_name = substr ($in_name [$row_name], 0, $ppos); // $new_in_name без расширения
        
            // Проверяем, совпадает ли имя файла из таблицы с проверяемым именем $new_filename
            if ($new_filename == $new_in_name) {               
                // Если имена совпадают, добавляем _последний id к записи файла перед расширением 
                $res = $CI->db->select_max ("id")->from ($table)->get ();
                $last = $res->row_array ();          
                return $new_filename.'_'.$last ['id'].'.'.substr ($filename, $ppos + 1);
            }
        }       
        return FALSE;  // Совпадений имен не найдено 
    }
  
}