<!-- Удаление модуля -->
<div class="cidialog mod_del_dialog">
    Удалить?
    <form action="<?=base_url()?>admin/pages/modules" method="post">
        <input type="hidden" value="" name="id">
        <input type="hidden" value="" name="number"> 
        <input type="hidden" value="" name="module_id">
        <input type="hidden" value="" name="module">
        <input type="hidden" value="module_delete" name="task">
        <div class="dialog_buttons">
            <input type="submit" class="yes" value="ОК">
            <input type="button" class="no" value="Отмена" onclick="$('.mod_del_dialog').dialog('close')">
        </div>                
    </form>
</div>

<!--  -->
