$(document).ready (function () {

  // Меню
  $("#menu_main .level1 a").hover(function(){
    $(this).addClass("set1");
    $(this).next().show(); 
  }, function() {   
    $(this).removeClass("set1");
    $(this).next().hide();      
  }); 

  $("#menu_main .level2").hover(function() {
    $(this).show();
    $(this).prev().addClass("set1");      
  }, function() {
    $(this).prev().removeClass("set1");
    $(this).hide(); 
  });
    
  // Ajax отправка формы 1
  $(".form1").submit(function() {       
    var data = $(this).serialize();      
    $.ajax ({
      url: "/ajax/form1_send",
      type: 'POST',
      data: data,
      error: function () { $("#form1_mes").empty().text("Ошибка отправки, проверьте данные!"); },
      success: function (html) { $("#form1_mes").empty().hide().fadeIn(400).append(html); } 
    });                       
    return false;    
  }); 
    
  // Ajax отправка формы 2
  $(".form2").submit(function() {       
    var data = $(this).serialize();      
    $.ajax ({
      url: "/ajax/form2_send",
      type: 'POST',
      data: data,
      error: function () { $("#form2_mes").empty().text("Ошибка отправки, проверьте данные!"); },
      success: function (html) { $("#form2_mes").empty().hide().fadeIn(400).append(html); } 
    });                       
    return false;    
  });   
    
  // Ajax отправка формы 3
  $(".form3").submit(function() {       
    var data = $(this).serialize();      
    $.ajax ({
      url: "/ajax/form3_send",
      type: 'POST',
      data: data,
      error: function () { $("#form3_mes").empty().text("Ошибка отправки, проверьте данные!"); },
      success: function (html) { $("#form3_mes").empty().hide().fadeIn(400).append(html); } 
    });                       
    return false;    
  }); 
    
  // Ajax отправка кастомной формы "ОФОРМИТЬ ЗАКАЗ"
  $("#order_form").submit(function() {       
    var data = $(this).serialize();      
    $.ajax ({
      url: "/ajax/order_form_send",
      type: 'POST',
      data: data,
      error: function () { $("#order_form_mes").empty().text("Ошибка отправки, проверьте данные!"); },
      success: function (html) { $("#order_form_mes").empty().hide().fadeIn(400).append(html); } 
    });                       
    return false;    
  }); 
    
  // Кастомные select
  $("select").wrap('<span class="sel_wrap"></span>').wrap('<span class="sel_wrap_inner"></span>'); 
   
  // Скроллинг формы 1
  $("#request_box1").css({"top":Math.round(($(window).scrollTop() + $(window).height() / 2 - 250))});
  $(window).scroll(function() { $("#request_box1").css({"top":Math.round(($(window).scrollTop() + $(window).height() / 2 - 250))}); });
  $(window).resize(function() { $("#request_box1").css({"top":Math.round(($(window).scrollTop() + $(window).height() / 2 - 250))}); });

  // Скроллинг формы 2
  $("#request_box2").css({"top":Math.round(($(window).scrollTop() + $(window).height() / 2 - 250))});
  $(window).scroll(function() { $("#request_box2").css({"top":Math.round(($(window).scrollTop() + $(window).height() / 2 - 250))}); });
  $(window).resize(function() { $("#request_box2").css({"top":Math.round(($(window).scrollTop() + $(window).height() / 2 - 250))}); });

  // Скроллинг формы 3
  $("#request_box3").css({"top":Math.round(($(window).scrollTop() + $(window).height() / 2 - 250))});
  $(window).scroll(function() { $("#request_box3").css({"top":Math.round(($(window).scrollTop() + $(window).height() / 2 - 250))}); });
  $(window).resize(function() { $("#request_box3").css({"top":Math.round(($(window).scrollTop() + $(window).height() / 2 - 250))}); });


  // owl carousel
  $(".portfolio").owlCarousel({
    navigation : true,
    navigationText: ["&larr; назад", "вперед &rarr;"], 
    slideSpeed : 300,
    paginationSpeed : 300,
    singleItem: true,
    lazyLoad : true
  });

  // Банер
  /*$("#banner").cycle({
    fx: "scrollVert",
    speed: 700,
    timeout: 4000,
  });*/ 

  // Hover и отображение первой вкладки
  /*$(".left_sec").eq(0).addClass("set");
  $(".right_sec").eq(0).show();*/ 
    
  // Блоки Наши Услуги
  /*$(".left_sec").click(function(){
      $(".left_sec").removeClass("set");
      $(".right_sec").hide();
      $(this).addClass("set");
      var i = $(this).index();
      $(".right_sec").eq(i).fadeIn(200);    
  });*/

  // Рандомный вывод картинок для страниц
  /*
  var rand_img = Math.round(Math.random()*(4-1)+1);
  $(".page_img_inner").attr("src", "/img/page/page_img/"+rand_img+".jpg");
  */

  // Показ / скрытие формы заявки на звонок    
  /*$("#zvonok").click(function() {    
      $("#request_box1").show(200);
      $.shadow();
      $("#shadow").click(function() {
		    $("#request_box1").hide(200);
		    $(this).remove();
      });  
  });*/
    
  // Написать письмо
  /*$("#letter").click(function() {    
      $("#request_box2").show(200);
      $.shadow();
      $("#shadow").click(function() {
		  $("#request_box2").hide(200);
		  $(this).remove();
      });
  });*/
    
  // Показ / скрытие формы отзывов    
  /*$("#lf").click(function() {    
      $("#request_box3").show(200);
      $.shadow();
      $("#shadow").click(function() {
		  $("#request_box3").hide(200);
		  $(this).remove();
      });  
  });*/
    
        
});