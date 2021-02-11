//= includes/jquery-ui.js
//= includes/jcf.js
//= includes/jcf-scrollable.js
//= includes/jcf-select.js

(function ($, window, document) {
  'use strict';
  var page = {
    init: function () {
      // page.datePicker();
      // page.showDetails();
      page.customSelect();
    },
    isDev: function () {
      return !$('html').hasClass('no-dev') || window.innerWidth < 1280;
    },
    datePicker: function () {
      var pickerWrap = $('.date-picker');
      var picker = $('#datepicker');
      picker.datepicker({
        dateFormat: "dd-MM-yy",
        altField: "#actualDate",
        beforeShow: function () { pickerWrap.addClass('active'); },
        onClose: function () { pickerWrap.removeClass('active'); }
      }).datepicker("setDate", new Date());
    },
    showDetails: function () {
      var showBtn = $('.show-details-btn');
      showBtn.on('click', function () {
        var $this = $(this);
        $this.toggleClass('active');
        if($this.hasClass('active')) {
          $this.text('hide details');
        } else {
          $this.text('show details');
        }
        $this.parents('tr').siblings('.course-details').fadeToggle();
      } );
    },
    customSelect: function () {
      jcf.setOptions('Select', {
        multipleCompactStyle: true,
        wrapNative: false,
        wrapNativeOnMobile: false,
        useCustomScroll: true,
        maxVisibleItems: 5
      });
      jcf.replaceAll();
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