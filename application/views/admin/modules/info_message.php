<? if ($this->session->flashdata ('go') != 0) { ?>
<script>
$(document).ready(function() { 
    block = $(".modules_sortable").find("#"+"<?=$this->session->flashdata ('go')?>");
    block.find(".module_switch").addClass('mshowed');
    block.find(".module").show().addClass("showed");
});
</script>
<? } ?>

<div id="info_message">
    <? if (($this->config->item ('extra_info') == 1 || isset ($auth_page)) && (!empty ($validation_errors) || $this->session->flashdata ('count') > 0)) { ?> 
        <script>$(document).ready(function(){ 
            $("#info_message").fadeIn(300).delay(3000).fadeOut(300);           
        });</script> 
        <?  
            echo $validation_errors; 
            for ($i=0; $i < $this->session->flashdata('count'); $i++) { 
                echo $this->session->flashdata ($i);  
            } 
        } elseif (!empty ($validation_errors)) { ?>
<script>
    $(document).ready(function(){ 
        $("#info_message").fadeIn(300).delay(3000).fadeOut(300); 
    });        
</script>
        
<? echo $validation_errors;
        } 
?>
</div>

