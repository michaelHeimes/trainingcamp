//= includes/slick.js

(function ($, window, document) {
  'use strict';
  var page = {
    init: function () {
      page.quoteSlider();
      page.popularCoursesSlider();
    },
    isDev: function () {
      return !$('html').hasClass('no-dev') || window.innerWidth < 1280;
    },
    popularCoursesSlider: function () {
      var slider = $('.popular-courses').find('.slides');
      var slide = slider.find('.slide');
      if (page.isDev()) {
        slider.slick({
          slidesToShow: 5,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 1280,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false
              }
            }
          ]
        });
      }
    },
    quoteSlider: function () {
      var slider = $('.quote-slider').find('.slides');
      var slideNum = $('.slide-num');
      slider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        appendArrows: $('.slide-num'),
        adaptiveHeight: true,
        speed: 1000,
        fade: true,
        cssEase: 'ease',
        responsive: [
          {
            breakpoint: 1280,
            settings: {
              arrows: false
            }
          }
        ]
      });
      slideNum.find('.slides-qty').text('0' + slider.find('.slide:not(.slick-cloned)').length);
      slider.on('afterChange', function (slick, currentSlide, nextSlide) {
        slideNum.find('.cur-slide').text('0' + parseInt(nextSlide + 1));
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