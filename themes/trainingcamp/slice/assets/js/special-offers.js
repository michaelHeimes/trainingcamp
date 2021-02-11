//= includes/slick.js

(function ($, window, document) {
  'use strict';
  var page = {
    init: function () {
      page.topSlider();
    },
    isDev: function () {
      return !$('html').hasClass('no-dev') || window.innerWidth < 1280;
    },
    topSlider: function () {
      $('.top-slider').slick({
        autoplay: true,
        autoplaySpeed: 5000,
        arrows: true,
        dots: true,
        draggable: false,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        swipe: true,
        touchMove: false
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