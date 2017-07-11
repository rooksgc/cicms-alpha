(function($){
  $.fn.cbox = function(options){
    // Задаем значения по умолчанию, если они еще не заданы:
    options = $.extend({
      labels : ['вкл','выкл']
    },options);

    return this.each(function(){
      var originalCheckBox = $(this), labels = [];

      // Проверяем атрибуты data-on / data-off:
      if(originalCheckBox.data('on')){
        labels[0] = originalCheckBox.data('on');
        labels[1] = originalCheckBox.data('off');
      } else labels = options.labels;

      // Создаем оформление нового чекбокса:
      var checkBox = $('<span>', {
        "class": 'cbox '+(this.checked?'checked':''),
        "html":  '<span class="cbContent">'+labels[this.checked?0:1]+'</span><span class="cbPart"></span>'
      });

      // Скрываем оригинальный чекбокс и вставляем кастомный:
      checkBox.insertAfter(originalCheckBox.hide());

      checkBox.click(function(){
        checkBox.toggleClass('checked');       
        var isChecked = checkBox.hasClass('checked');

        // Синхронизация с оригинальным чекбоксом:
        originalCheckBox.attr('checked',isChecked);
        checkBox.find('.cbContent').html(labels[isChecked?0:1]);
                
        // Меняем статус скрытого доп. поля  ? 1 : 0
        $(this).next().val(isChecked?1:0);                          
      });

      originalCheckBox.bind('change',function(){
        checkBox.click();
      });
    });
    
  };
})(jQuery);