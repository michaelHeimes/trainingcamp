//= includes/slick.js
//= includes/jquery-ui.js
(function ($, window, document) {
  'use strict';
  var page = {
    init: function () {
      page.quoteSlider();
      page.datePicker();
      page.showDetails();
    },
    isDev: function () {
      return !$('html').hasClass('no-dev') || window.innerWidth < 1280;
    },
    quoteSlider: function () {
      var slider = $('.quote-slider').find('.slides');
      var slideNum = $('.slide-num');
      slider.slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        appendArrows: $('.slide-num'),
        adaptiveHeight: true,
        responsive: [
          {
            breakpoint: 1280,
            settings: {
              slidesToShow: 1,
              arrows: false
            }
          }
        ]
      });
      var qty = slider.find('.slide:not(.slick-cloned)').length;
      slideNum.find('.slides-qty').text((qty < 10) ? '0' + qty : qty);
      slider.on('afterChange', function (slick, currentSlide, nextSlide) {
        slideNum.find('.cur-slide').text((parseInt(nextSlide+1) < 10) ? '0'
          + parseInt(nextSlide+1) : parseInt(nextSlide+1));
      });
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