(function ($, window, document) {
  'use strict';
  var page = {
    init: function () {
      page.forgotPass();
    },
    isDev: function () {
      return !$('html').hasClass('no-dev') || window.innerWidth < 1280;
    },
    forgotPass: function () {
      var formLink = $('.form-row a');
      formLink.on('click', function () {
        var $this = $(this);
        var tabTarget = $this.attr('href');

        $(tabTarget).show('slow').siblings('form').hide('slow');

        return false;
      });
    },
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