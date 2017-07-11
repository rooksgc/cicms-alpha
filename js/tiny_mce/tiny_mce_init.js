// Файл настроек для редактора TinyMCE | 19.09.2013 14:24
 
tinyMCE.init({
	mode:"specific_textareas",      
	editor_deselector:"mceNoEditor",
  document_base_url : "/",
  convert_urls:false,
  relative_urls:false,
  width: "100%",
	height: "200",
	theme:"advanced",
	language:"ru",
	element_format : "html",
	plugins : "autolink,lists,spellchecker,pagebreak,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,images,codemagic",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,forecolor,backcolor,|,link,unlink,|,bullist,numlist,|,undo,redo,|,codemagic",
	theme_advanced_buttons2 : "tablecontrols,|,visualaid,|,sub,sup,|,charmap,iespell,|,media,image,images,|,spellchecker,|,visualchars,|,help",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
    theme_advanced_resize_horizontal : false,
    theme_advanced_resizing_use_cookie : true,
    
	// Skin options
	skin : "o2k7",
	skin_variant : "silver"
});