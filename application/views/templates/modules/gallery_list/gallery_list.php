<? $gal_images = crud::getElements (array ('table' => 'gallery', 'where' => array ('gallery_id' => $module ['id']), 'order' => array ('by' => 'sort', 'dir' => 'ask'))); ?> 
<div class="gallery">
    <h2><?=$module ['title']?></h2> 
    <? if (!empty ($gal_images)) { 
            foreach ($gal_images as $image) { 
                $ppos = strrpos($image ['img'], '.');
                $mini ['img'] = substr ($image ['img'], 0, $ppos).'_mini.'.substr ($image ['img'], $ppos + 1); ?>
        <a style="background: url(<?=base_url()."img/gallery/".$module ['id']."/".$mini ['img']?>) no-repeat 50% center transparent" class="gal_image_container fancybox" rel="gallery<?=$image ['gallery_id']?>" href="<?=base_url()."img/gallery/".$module ['id']."/".$image ['img']?>" title="<?=$image ['img_title']?>" alt="<?=$image ['img_alt']?>">                  
            <? echo ($image ['img_title'] !== '')? "<p class='gal_image_text'>".$image ['img_title']."</p>" : ""; ?>                 
        </a>                             
      <? } } ?> 
      <div class="clearfix"></div>
</div>

  