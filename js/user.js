// Дополнительные скрипты для страниц сайта
$(document).ready (function () {                                                  
    
  // Ajax добавление отзывов с сайта
  $(".feedback_add").submit(function () {     
    var data = $(this).serialize();
    var mes = $("#feedback_mes");               
    $.ajax ({
      url: "/ajax/feedback_add",
      type: 'POST',
      data: data,
      error: function () { mes.empty().text("Ошибка! Обновить данные не удалось!").show(150).delay(5000).slideUp(200); },
      success: function (html) { mes.empty().append(html).show(150);} //.delay(5000).slideUp(200);} 
    });                    
    return false;    
  });
    
  // Ajax задать вопрос с сайта
  $(".faq_add").submit(function () {     
    var data = $(this).serialize();
    var mes = $(this).parent().next();               
    $.ajax ({
      url: "/ajax/faq_add",
      type: 'POST',
      data: data,
      error: function () { mes.empty().text("Ошибка! Обновить данные не удалось!").show(150).delay(5000).slideUp(200); },
      success: function (html) { mes.empty().append(html).show(150);} //.delay(5000).slideUp(200);} 
    });                    
    return false;    
  });    

  // Обновить капчу
  $(".update_captcha").click(function () {
    var rand = Math.round (Math.random() * 999);
    $(this).parent().find(".captcha").attr("src", "/ajax/captha_img/"+rand);
    return false;
  });
    
  // Обновление рисунка капчи
  $(".captcha_code").focus (function () {
    var rand = Math.round (Math.random() * 999);
    $(this).parent().find(".captcha").attr("src", "/ajax/captha_img/"+rand); 
    return false;   
  });

  // Постраничная навигация для модулей на сайте
  $(".m_group").not('.m_group[data-id=1]').hide();	
  var pages = $('.m_group').length;  //alert (pages);
  if(pages > 1){
    $('.top_paging').fadeIn(300);
    var links = '';
    for (var i = 1; i <= pages; i++) {
    	class_set = '';
    	if (i==1) var class_set=' set';
    	links = links + '<a href="#" class="page_link' + class_set + '">' + i + '</a>'; 
    };
    $('#next_page').before(links);
  }
    
  // Set для текущей страницы навигации
  $("a.page_link").click(function(event){
    event.preventDefault();
    $('a.page_link').removeClass('set');
    $(this).addClass('set');
    var page = $(this).text();
    $('.m_group').hide();
    $('.m_group[data-id=' + page + ']').fadeIn(300);
    $(window).scrollTop(0,0);
  });    

  // Cross
  $(".cross").click(function(){
    $(this).parent().hide();
    $.unshadow();
  });
    
  // Меню jquery     
  $('.level1 li').hover (
    function () {
      $('.level2', this).show(100).addClass("showed");
      return false;
    },
    function () {
      $('.level2', this).hide(100).removeClass("showed");
    }
  ); 
    
  // Fancybox
  $(".fancybox").fancybox();
    
  // Плавная прокрутка к якорям
  /*
  $("a[href*=#]").bind("click", function(e){
    var anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: $(anchor.attr('href')).offset().top
    }, 1000);
    e.preventDefault();
  });
  */
   
  /* Текущая позиция меню и др. */
  /* 
  $('.level1 li').each(function(){
    $(this).removeClass('set');
    var pos = window.location.href;
    var thisTab = this.href;
    var thisTabHahs = window.location.hash;
    if(pos == thisTab || pos == thisTab + thisTabHahs){
      $(this).addClass('set');
    }
  }); 
  */
   
});


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

// Очистка полей форм
function clear_field (field) {
  if (field.value==field.defaultValue) {
    field.value=''
  }
}

// Проверка - чистое ли поле у формы    
function check_field (field) {
  if (field.value=='' || field.value==' ') {
    field.value=field.defaultValue
  }
}

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

// Кнопка навигации -> предыдущая страница
function prev_page () {
	var current_page = $('a.page_link.set').text();
	if(current_page != 1){
		$('a.page_link').removeClass('set');	
		$('.m_group').hide();
		$('.m_group[data-id=' + (current_page - 1) + ']').fadeIn(300);
		current_page--;
		$('a.page_link').eq(current_page-1).addClass('set');
	}	
}

// Кнопка навигации -> следующая страница
function next_page () {
	var current_page = $('a.page_link.set').text();
	var pages = $('.m_group').length;
	if(current_page != pages){
		$('a.page_link').removeClass('set');	
		$('.m_group').hide();
		$('a.page_link').eq(current_page).addClass('set');
		current_page++;
		$('.m_group[data-id=' + current_page + ']').fadeIn(300);
	}
}        