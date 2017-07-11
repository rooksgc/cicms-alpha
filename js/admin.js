$(document).ready(function(){

  // Определяем iOS устройства
  if (!/ip(hone|od|ad)/i.test(navigator.userAgent)) {  
    // Если НЕ iOS - корректируем позиционирование body
    $("body").css("position", "relative");
  }

  // Выпадающее меню - добавить/удалить раздел     
  $(".cud_menu").click(function(){
    var e = $(this).next();
    if (e.hasClass('showed')) {
      e.slideUp({
        duration: 370,
        easing: 'easeOutCubic'
      }).removeClass('showed');
    } else {
      $(".cud_submenu").slideUp(150).removeClass('showed');
      e.slideDown({
        duration: 370,
        easing: 'easeOutCubic'
      }).addClass('showed');
    }
  });
    
  // Удаление изображения раздела
  $(".page_img_del").click(function(){            
      $(".page_img_del_dialog").dialog('open');
  });   
  $(".page_img_del_dialog").dialog({
    autoOpen : false,
    modal: true,
    resizable: false,
    position: ["center", "center"],
    minWidth : 300,
    height : 200,
    buttons : {          
      "ОК": function(){
        var id = $(this).attr("data-id"); 
        $.ajax ({
          url: "/admin/pages/page_img_del",
          type: 'POST',
          data: {id : id},
          error: function () { $("#info_message").empty().text("Ошибка! Обновить данные не удалось!"); show_info_message (); },
          success: function () { location.reload(); } 
        });
        $(this).dialog('close');
      },
      "Отмена": function(){
        $(this).dialog('close');
      }
    }
  });
    
  // Удаление изображения новости
  $(".news_img_del").click(function(){    
    id = $(this).attr("data-id");        
    $(".news_img_del_dialog"+id).dialog('open');
  }); 
  $(".news_img_del_dialog").dialog({
    autoOpen : false,
    modal: true,
    resizable: false,
    position: ["center", "center"],
    minWidth : 300,
    height : 200,
    buttons : {          
      "ОК": function(){
        $.ajax ({
          url: "/admin/news_list/news_img_del",
          type: 'POST',
          data: {id : id},
          error: function () { $("#info_message").empty().text("Ошибка! Обновить данные не удалось!"); show_info_message (); },
          success: function () { location.reload(); } 
        });
        $(this).dialog('close');
      },
      "Отмена": function(){
        $(this).dialog('close');
      }
    }
  });    

  // Сортировка модулей
  $(".modules_sortable").each(function(){
    $(this).sortable ({
      items: ".module_container_sortable",
      stop: function (){ 
        var msorted = $(this).sortable("toArray");  //alert (msorted);
        var pageid = $(".set_page").find("input[name=id]").val();        
        // Возвратить сортировку по порядку для модулей
        var count = 1;
        $(".module_container_sortable").each(function(){
          $(this).attr('id', count);
          $(this).find(".mdel").attr('data-number', count);  
          $(this).find("input[name=number]").val(count); 
          count++;    
        });                
        $.ajax ({
          url: "/admin/ajax_admin/modules_sort",
          type: 'POST',
          data: {mitems: msorted, pageid: pageid},
          error: function () {
            //$(".mmessage").text("Ошибка сортировки!");
          },
          success: function () {
            //$(".mmessage").fadeIn(700).text("Сохранено").delay(1000).fadeOut(700);
          } 
        });  
      }
    });    
  });
    
  // Отключение сортировки модулей по умолчанию
  if ($("#sort_switch").hasClass('sort_off')){ 
    $(".modules_sortable").sortable('disable');
  }
    
  // Переключатель сортировки модулей
  $("#sort_switch").click(function(){
    if ($(this).hasClass('sort_on')) {
      $(this).removeClass('sort_on').addClass('sort_off').html("сортировка отключена");
      $(".modules_sortable").sortable('disable');   
    } else {  
      $(this).removeClass('sort_off').addClass('sort_on').html("сортировка включена");
      $(".modules_sortable").sortable('enable');   
    }    
  });
    
  // Скрыть/раскрыть содержание блоков модулей
  $("#modules_uncover").click(function(){
    if ($(this).hasClass('modules_visible')) { 
      $(this).removeClass('modules_visible').addClass('modules_hidden').html("развернуть все блоки");
      $(".module_switch").removeClass("mshowed");
      $(".module").removeClass("showed").slideUp({
        duration: 370,
        easing: 'easeOutCubic'
      });     
    } else {  
      $(this).removeClass('modules_hidden').addClass('modules_visible').html("свернуть все блоки");
      $(".module_switch").addClass("mshowed");
      $(".module").addClass("showed").slideDown({
        duration: 370,
        easing: 'easeOutCubic'
      });    
    }             
  });
    
  // Toggle для модулей
  $('.module_switch').click(function(){
    var e = $(this).next();
    $('.module_switch').removeClass('mshowed'); 
    if (e.hasClass('showed')) {     
      e.removeClass('showed').slideToggle({
        duration: 370,
        easing: 'easeOutCubic'
      });   
    } else {
      $(this).addClass('mshowed');
      $('.module').removeClass('showed').hide(150);
      e.slideToggle({
        duration: 370,
        easing: 'easeOutCubic'
      }).addClass('showed');
    }
  });   
    
  // Календарь (Datepicker)
  $(function(){
    $.datepicker.setDefaults(
      $.extend($.datepicker.regional["ru"])
    );
    $(".datepicker").datepicker();
  });
    
  // Замена "Обзора"
  $(".upload_image_input input, .image_input input, .upload_news_image_input input").change(function(){
    image_button(this);
  });
    
  function image_button(e) {
    var name = $(e).val();
    var reWin = /.*\\(.*)/;
    var fileTitle = name.replace(reWin, "$1"); //выдираем название файла для w*s
    var reUnix = /.*\/(.*)/;
    fileTitle = fileTitle.replace(reUnix, "$1"); //выдираем название для *nix
    $(e).parent().next().html(fileTitle);
  }
  
  // Toggle для записи блога    
  $(".bt_show").click(function(){
    var bt = $(this).next();
    if (bt.hasClass("btshowed")) {
      $(this).val("Показать анонс и текст");
      bt.removeClass("btshowed").slideToggle({                
        duration: 370,
        easing: 'easeOutCubic'}
      );     
    } else {
      $(this).val("Скрыть анонс и текст");
      bt.addClass("btshowed").slideToggle({
        duration: 370,
        easing: 'easeOutCubic'}
      ); 
    }
  });
  
  // Сортировка изображений в галерее
  $(".gal_items_sortable").sortable({
    stop: function (){
      var sorted = $(this).sortable("toArray");
      $.ajax ({
        url: "/admin/ajax_admin/gallery_sort",
        type: 'POST',
        data: {items: sorted},
        error: function () {
          // $("#").text("Ошибка сортировки!");
        },
        success: function () {
          // $("#").fadeIn(700).text("Сохранено").delay(1000).fadeOut(700);
        } 
      });  
    }
  });
    
  // Сортировка разделов в меню
  $(".menu_sortable").sortable ({
    axis: "y",
    revert: true,
    cursor: "n-resize",
    stop: function (){
      var sorted = $(this).sortable("toArray");
      $.ajax ({
        url: "/admin/ajax_admin/menu_sort",
        type: 'POST',
        data: {items: sorted},
        error: function () {
          // $("#").text("Ошибка сортировки!");
        },
        success: function () {
          // $("#").fadeIn(700).text("Сохранено").delay(1000).fadeOut(700);
        } 
      });  
    }
  });           
    
  // Ajax сохранение названия галереи
  $(".gallery_title_save").submit(function() {       
    var data = $(this).serialize();
    $.ajax ({
      url: "/admin/gallery_list/gallery_title_save",
      type: 'POST',
      data: data,
      error: function () { $("#info_message").empty().text("Ошибка! Обновить данные не удалось!"); show_info_message (); },
      success: function (html) { $("#info_message").empty().append(html); show_info_message (); } 
    });                       
    return false;    
  });
    
  // Ajax сохранение title и alt у изображений галереи
  $(".gallery_update_image_params").submit(function() {       
    var data = $(this).serialize();
    $.ajax ({
      url: "/admin/gallery_list/gallery_update_image_params",
      type: 'POST',
      data: data,
      error: function () { $("#info_message").empty().text("Ошибка! Обновить данные не удалось!"); show_info_message (); },
      success: function (html) { $("#info_message").empty().append(html); show_info_message (); } 
    });                       
    return false;    
  });    
       
  // Ajax обновление названия блока отзывов + отправка с сайта on/off
  $(".feedbacks_update_params").submit(function() {       
    var data = $(this).serialize();  
    $.ajax ({
      url: "/admin/feedback_list/feedbacks_update_params",
      type: 'POST',
      data: data,
      error: function () { $("#info_message").empty().text("Ошибка! Обновить данные не удалось!"); show_info_message (); },
      success: function (html) { $("#info_message").empty().append(html); show_info_message (); } 
    });                       
    return false;    
  }); 
    

  // Ajax обновление названия блока вопросов-ответов + отправка с сайта on/off
  $(".faq_update_params").submit(function() {       
    var data = $(this).serialize();  
    $.ajax ({
      url: "/admin/faq_list/faq_update_params",
      type: 'POST',
      data: data,
      error: function () { $("#info_message").empty().text("Ошибка! Обновить данные не удалось!"); show_info_message (); },
      success: function (html) { $("#info_message").empty().append(html); show_info_message (); } 
    });                       
    return false;    
  }); 
    
  // Ajax обновление названия новостной ленты
  $(".news_update_params").submit(function() {       
    var data = $(this).serialize();
    $.ajax ({
      url: "/admin/news_list/news_update_params",
      type: 'POST',
      data: data,
      error: function () { $("#info_message").empty().text("Ошибка! Обновить данные не удалось!"); show_info_message (); },
      success: function (html) { $("#info_message").empty().append(html); show_info_message (); } 
    });                       
    return false;    
  });     

  // Ajax обновление параметров вопросов-ответов
  $(".faq_update_this").submit(function() {       
    var data = $(this).serialize();   
    $.ajax ({
      url: "/admin/faq_list/faq_update_this",
      type: 'POST',
      data: data,
      error: function () { $("#info_message").empty().text("Ошибка! Обновить данные не удалось!"); show_info_message (); },
      success: function (html) { $("#info_message").empty().append(html); show_info_message (); } 
    });                       
    return false;    
  }); 
    
    
  // Кнопка "добавить новость"
  $(".news_add_button").click(function(){
    number = $(this).parents(".module_container_sortable").attr("id");
    $(".news_add_dialog").find("input[name=number]").val(number);
    $(".news_add_dialog").dialog('open');
  });     
  $(".news_add_dialog").dialog({
    autoOpen : false,
    modal: true,
    position: ["center", "center"],
    width : 800
  });          
     
  // Кнопка "редактировать новость"
  $(".news_edit_button").click(function(){
    id = $(this).attr("data-id");
    number = $(this).parents(".module_container_sortable").attr("id");
    $(".news_edit_dialog"+id).find("input[name=number]").val(number);
    $(".news_edit_dialog"+id).dialog ('open'); 
  });   
  $(".news_edit_dialog").dialog({ 
    autoOpen : false,
    modal: true,
    position: ["center", "center"],
    minWidth : 800
  });
    
    
  // Кнопка "добавить вставку"
  $(".include_add_button").click(function(){
    $(".include_add_dialog").dialog('open');
  });     
  $(".include_add_dialog").dialog({
    autoOpen : false,
    modal: true,
    position: ["center", "center"],
    width : 1000
  });    
    
  // Кнопка "редактировать вставку"
  $(".include_edit_button").click(function(){
    id = $(this).attr("data-id");
    $(".include_edit_dialog"+id).dialog ('open'); 
  });   
  $(".include_edit_dialog").dialog({ 
    autoOpen : false,
    modal: true,
    position: ["center", "center"],
    minWidth : 1000
  });
  
  // Кнопка "редактировать отзыв"
  $(".feedback_edit_button").click(function(){
    id = $(this).attr("data-feed");
    number = $(this).parents(".module_container_sortable").attr("id");
    $(".feedback_edit_dialog"+id).find("input[name=number]").val(number);
    $(".feedback_edit_dialog"+id).dialog('open');
  });     
  $(".feedback_edit_dialog").dialog({
    autoOpen : false,
    modal: true,
    position: ["center", "center"],
    minWidth : 750
  });    

  // Ajax отправка уведомления на e-mail об ответе (вопрос-ответ)
  $(".faq_email_notice").click(function() {       
    faq_id = $(this).attr("data-faqid"); 
    email = $(this).attr("data-email");
    $(".faq_dialog"+faq_id).dialog('open');                      
  });
    
  // Окно подтверждения отправки уведомления на e-mail (вопрос-ответ)
  $(".faq_dialog").dialog({
    autoOpen : false,
    modal: true,
    resizable: false,
    position: ["center", "center"],
    minWidth : 300,
    height : 200,
    buttons : {          
      "ОК": function(){ 
        $.ajax ({
          url: "/admin/faq_list/faq_email_notice",
          type: 'POST',
          data: {faq_id:faq_id, email:email},
          error: function () { $("#info_message").empty().text("Ошибка! Отправить уведомление не удалось!"); show_info_message (); },
          success: function (html) { $("#info_message").empty().append(html); show_info_message (); $(".faq_dialog").dialog('close'); } 
        }); 
      },
      "Отмена": function(){
        $(this).dialog('close');
      }
    }
  });         

  // Подтверждение удаления раздела page
  $(".page_del").click(function(e) {
    e.preventDefault();
    pageid = $(this).attr("data-pageid");
    $(".page_del_dialog"+pageid).dialog('open');                           
  });

  // Окно подтверждения удаления раздела page
  $(".page_del_dialog").dialog({
    autoOpen : false,
    modal: true,
    resizable: false,
    position: ["center", "center"],
    minWidth : 300,
    height : 200,
    buttons : {          
      "ОК": function(){ 
        window.location.href = "/admin/pages/page_del/" + pageid;
        $(this).dialog('close');
      },
      "Отмена": function(){
        $(this).dialog('close');
      }
    }
  });

  // Подтверждение удаления вопроса-ответа
  $(".faq_del").click(function() {
    id = $(this).attr("data-faqid");
    number = $(this).parents(".module_container_sortable").attr("id");
    $(".faq_del_dialog"+id).find("input[name=number]").val(number);        
    $(".faq_del_dialog"+id).dialog('open');                           
  });
    
  // Подтверждение удаления отзыва
  $(".feed_del").click(function() {
    id = $(this).attr("data-id");
    number = $(this).parents(".module_container_sortable").attr("id");
    $(".feed_del_dialog"+id).find("input[name=number]").val(number);     
    $(".feed_del_dialog"+id).dialog('open');                           
  }); 
    
  // Подтверждение удаления новости
  $(".news_del").click(function() {
    id = $(this).attr("data-id");
    number = $(this).parents(".module_container_sortable").attr("id");
    $(".news_del_dialog"+id).find("input[name=number]").val(number);        
    $(".news_del_dialog"+id).dialog('open');                           
  });   

  // Подтверждение удаления категории блога
  $(".blogcat_del").click(function() {
    id = $(this).attr("data-blogcatid");
    $(".blog_cat_del_dialog"+id).dialog('open');                           
  });
    
  // Подтверждение удаления вставки
  $(".include_del").click(function() {
    id = $(this).attr("data-id");
    $(".include_del_dialog"+id).dialog('open');                           
  });    

  // Подтверждение удаления модуля
  $(".mdel").click(function() {
    id = $(this).attr("data-id");
    module = $(this).attr("data-module");
    moduleid = $(this).attr("data-moduleid");
    number = $(this).attr("data-number");
    $(".mod_del_dialog").dialog('open');
    $(".mod_del_dialog input[name=id]").val(id); 
    $(".mod_del_dialog input[name=module]").val(module);
    $(".mod_del_dialog input[name=module_id]").val(moduleid);
    $(".mod_del_dialog input[name=number]").val(number);                          
  });   

  // Окно подтверждения удаления
  $(".mod_del_dialog, .faq_del_dialog, .feed_del_dialog, .blog_cat_del_dialog, .news_del_dialog, .include_del_dialog").dialog({
    autoOpen : false,
    modal: true,
    resizable: false,
    position: ["center", "center"],
    minWidth : 300,
    height : 200
  });
    
  // Кастомные чекбоксы
  $(".cbSettings").cbox({labels: ["Вкл", "Выкл"]});
  $(".cbShowed").cbox({labels: ["Показана", "Скрыта"]});
  $(".cb_feedbacks, .cb_faq, .cb_yesno").cbox({labels: ["Да", "Нет"]});    
    
  
}); // ready - конец    

// Получение данных из базы по ajax-запросу
function ajax_get (table, id, field, block) {
  $.ajax ({
    url: "/ajax/ajax_get",
    type: 'POST',
    data: { table:table, id:id, field:field },
    error: function () { /**/ },
    success: function (html) { $(block).empty().append(html); } 
  });    
}

// Выпадающее сообщение о событиях
function show_info_message () {
  $("#info_message").fadeIn(300).delay(3000).fadeOut(300);
};    

// Установка cookie
function setCookie (name, value, expires, path, domain, secure) {
  document.cookie = name + "=" + escape(value) +
  ((expires) ? "; expires=" + expires : "") +
  ((path) ? "; path=" + path : "") +
  ((domain) ? "; domain=" + domain : "") +
  ((secure) ? "; secure" : "");
} 

// Получение cookie    
function getCookie (name) {
	var matches = document.cookie.match(new RegExp(
	  "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	))
	return matches ? decodeURIComponent(matches[1]) : undefined
}  