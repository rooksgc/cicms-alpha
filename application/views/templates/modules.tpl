<? // Показываем модули
if ($modules) {    
    $m_list = unserialize ($modules);       
    if ($pagination !== "0") {
        require_once ('modules/paging_standart.php');  
    } else {
        foreach ($m_list as $number => $each) {          
            $module = crud::get_modules ($each ['name'], $each ['module_id']);
            require ('modules/'.$each['name'].'/'.$each ['name'].'.php');  
        }
    } 
}
