(function(){ 
   $(document).ready(function() {
      $.nette.init();

      $.nette.ext({
         before: function (xhr, settings) {
            if (!settings.nette) {
               return false;
            }
   
            var question = settings.nette.el.data('confirm');
            if (question) {
               return confirm(question);
            }
         }
      });
   });

})(jQuery);