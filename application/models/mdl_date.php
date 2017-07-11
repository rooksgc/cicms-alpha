<? // Модель для работы с датой и временем

if (!defined ('BASEPATH')) exit ('BASEPATH UNDEFINED');

class Mdl_date extends CI_Model {
    
    // Функция преобразует дату из формата MySql (yyyy:mm:dd) в формат dd:mm:yyyy
    public function newdate ($date, $ds, $month = "") { 
        $m = array ('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
        $temp = explode ("-", $date);
        if ($month == TRUE) $temp [1] += 0 - 1;  // Коррекция месяца 
        
        return ($month == TRUE)? $temp [2].$ds.$m [$temp [1]].$ds.$temp [0] : $temp [2].$ds.$temp [1].$ds.$temp [0];    
    }
    
    // Функция возвращает преобразования функции newdate - 27.05.2014 -> 2014-05-27  // $ds - разделитель старой даты $date '.'
    public function olddate ($date, $ds) { 
        $temp = explode ($ds, $date);       
        return $temp [2]."-".$temp [1]."-".$temp [0];    
    }    
  
}