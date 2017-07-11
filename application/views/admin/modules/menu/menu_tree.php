<!-- Меню в админке -->
<div id="menu_tree">
    <ul>
        <li id="1">
            <a class="menu_items" title="Редактировать" href="<?=base_url()?>admin/pages/page_edit/1">Главная</a>
            <div class="cud_menu"></div>
            <div class="cud_submenu">
                <a href="<?=base_url()?>admin/pages/page_add/1">добавить</a>
            </div>
        </li>
<?
$menu_admin = tree::get_tree ('menu', 1, 10);
tree::menu_admin ($menu_admin, 1);
?>            
    </ul>    
</div>
