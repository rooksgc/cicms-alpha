<? // Модель построения дерева

if (!defined ('BASEPATH')) exit ('basepath undefined');

class Tree extends CI_Model {    
    
	public function __construct () {
    	parent:: __construct (); 
	}

    // Получаем дерево с указанным отрезком уровней и представляем parent_id начальным ключем
    public function get_tree ($table, $lvl_start, $lvl_end) {         
        $qr = $this->db->select ("id, parent_id, level, path, title, in_menu")->from ($table)->where ("level >= $lvl_start AND level <= $lvl_end")->order_by ("sort")->get ();
        $menu = $qr->result_array (); 
                $cat = array ();        
        if (!empty ($menu)) {
            for ($i = 0; $i < count ($menu); $i++) { 
                $row = $menu [$i];
                if (empty ($cat [$row ['parent_id']])) {
                    $cat [$row ['parent_id']] = array ();        
                } 
                $cat [$row ['parent_id']][] = $row;        
            }      
            return $cat;
        }   
    }
    
    // Вывод меню из таблицы $table, начиная с раздела с указанным $parent_id
        
    // Главное меню на сайте
    public function menu_main ($table, $parent_id) {    
        // Условие выхода из рекурсии - кончились потомки у родителя 
        if (empty ($table [$parent_id])) { return; }        
        $level = $table [$parent_id] [0] ['level'];          
        echo "<ul class='level$level'>";
        for ($i = 0; $i < count ($table [$parent_id]); $i++) {
            if ($table [$parent_id][$i]['in_menu'] == 1) {       
                $lvl = $table [$parent_id][$i]['level'];
                $pth = $table [$parent_id][$i]['path'];
                if ($lvl > 1) {
                    $path_array = explode("/", $pth); 
                    $cur_path = array_pop($path_array);
                    $class = ($this->uri->segment($lvl) == $cur_path)? "class='set'" : "";       
                } else {
                    $class = ($this->uri->segment($lvl) == $pth)? "class='set'" : "";    
                }
                echo "<li><a ".$class." href=".base_url ().$pth.">".$table [$parent_id][$i]['title']."</a>";
                $level++;           
                tree::menu_main ($table, $table [$parent_id][$i]['id']); // Рекурсия
                $level--;
                echo "</li>"; 
            }
        }
        echo "</ul>";    
        return TRUE;
    }   

    // Дерево разделов в админке
    public function menu_admin ($table, $parent_id) {
        if (empty ($table [$parent_id])) { return; }
        $level = $table [$parent_id] [0] ['level'];
        $lvl = ($level * 6)."px";  
        echo "<ul class='level$level menu_sortable' style='margin-left: $lvl'>";
        for ($i = 0; $i < count ($table [$parent_id]); $i++) {    
            echo "<li id=".$table [$parent_id][$i]['id'].">
                <a class='menu_items' href=".base_url ()."admin/pages/page_edit/".$table [$parent_id][$i]['id'].">".$table [$parent_id][$i]['title']."</a>
                <div class='cud_menu'></div>
                <div class='cud_submenu'>
                    <a href=".base_url ()."admin/pages/page_add/".$table [$parent_id][$i]['id'].">добавить</a>
                    <a class='page_del' data-pageid=".$table [$parent_id][$i]['id'].">удалить</a>
                    <div class='cidialog page_del_dialog page_del_dialog".$table [$parent_id][$i]['id']."'>Удалить раздел?</div> 
                </div>";
            $level++;           
            tree::menu_admin ($table, $table [$parent_id][$i]['id']); // Рекурсия
            $level--;
            echo "</li>";
        }
        echo "</ul>";         
        return TRUE;   
    }
  
    // Пересортировка элементов с присвоением последовательных порядковых номеров 0 +
    public function resort ($table, $param1, $param2) {
        $data = array (); 
        $qr = $this->db->select ("sort")->from ($table)->where ($param1, $param2)->order_by ("sort", "ASC")->get ();
        $res = $qr->result_array ();  // массив с текущей сортировкой        
        for ($i = 0; $i < count ($res); $i++) {
            $data ['sort'] = $i;
            $j = $res [$i] ['sort'];                     
            $this->db->update ($table, $data, "sort = $j AND $param1 = $param2");         
        }
        return TRUE;
    }
    
    // Хлебные крошки для разделов меню
    public function breadcrumbs ($table) {
        $total_segments = $this->uri->total_segments ();
        $crumbs = array ();
        $crumb_path = "";
        $delimiter = "<div class='delimiter'>:</div>";        
        for ($i = 1; $i <= $total_segments; $i++) {
            $crumb_path .= ($i > 1)? "/".$this->uri->segment ($i) : $this->uri->segment ($i);
            foreach ($table as $page) {
                for ($c = 0; $c < count ($page); $c++) {   
                    if ($page [$c]['path'] == $crumb_path) {
                        $crumbs_path [] = $page [$c]['path'];
                        $crumbs_title [] = $page [$c]['title'];
                        $c = count ($page);    
                    } 
                }
            }          
        }         
        // Показываем цепочку
        echo "<a class='bhome' href=".base_url ()."></a>". $delimiter;         
        for ($j = 0; $j < count ($crumbs_path); $j++) {
            echo (count ($crumbs_path) - $j == 1)? "<span>".$crumbs_title [$j]."</span>" : "<a href=".base_url ().$crumbs_path [$j].">".$crumbs_title [$j]."</a>". $delimiter;
        }        
        return TRUE; 
    } 
    
    // Хлебные крошки для новостей
    public function breadcrumbs_news($id, $title) {             
        $delimiter = "<div class='delimiter'>:</div>";        
        $path = $this->uri->segment(2);  
        // Показываем цепочку
        echo "<a class='bhome' href=".base_url()."></a>".$delimiter."<a href='/news'>Новости</a>".$delimiter."<span>".$title."</span>";        
        return TRUE; 
    }     
      
}