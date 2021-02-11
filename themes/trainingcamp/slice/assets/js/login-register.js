(function ($, window, document) {
  'use strict';
  var page = {
    init: function () {
      //page.forgotPass();
    },
    isDev: function () {
      return !$('html').hasClass('no-dev') || window.innerWidth < 1280;
    },
    // forgotPass: function () {
    //   $('.forgot-pass').on('click', function () {
    //     var $this = $(this);
    //     var tabTarget = $this.attr('href');
    //
    //     $('.tab-nav li').removeClass('active');
    //     $(tabTarget).addClass('active').show().siblings('.tab-content').hide();
    //
    //     return false;
    //   });
    // },
    load: function () {
    },
    resize: function () {
    },
    scroll: function () {
    }
  };

  $(document).ready(page.init);
  $(window).on({
    'load': page.load,
    'resize': page.resize,
    'scroll': page.scroll
  });

})(jQuery, window, document);