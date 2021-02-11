//= includes/jquery.jscrollpane.js
//= includes/jquery.mousewheel.js

(function ($, window, document) {
  'use strict';
  var page = {
    init: function () {
      page.noDev();
      page.mobileMenu();
      page.tabs();
      page.darkHeader();
      page.dropdown();
      page.customScroll();
      page.search();
      page.showFilterOptions();
      page.stickyHeader();
      page.subscribe();
    },
    noDev: function () {
      if ((typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1)) {
        $('.no-dev').removeClass('no-dev');
      }
    },
    isDev: function () {
      return !$('html').hasClass('no-dev') || window.innerWidth < 1280;
    },
    darkHeader: function () {
      if (!$('.top-bg').length) {
        $('.page').addClass('inner');
        $('.header_').addClass('dark');
      }
    },
    stickyHeader: function () {
      var scrolled = $(document).scrollTop();
      var header = $('.header_');
      if (scrolled > 10) {
        header.addClass('sticky');
      } else {
        header.removeClass('sticky');
      }
    },
    mobileMenu: function () {
      var header = $('.header_');
      var menuBtn = header.find('.menu-btn');
      menuBtn.on('click', function () {
        $(this).toggleClass('active-btn');
        $('html').toggleClass('no-scroll');
        header.find('.navigation').toggleClass('active');
      });
    },
    tabs: function () {
      $('.tab-nav a').on('click', function () {
        var $this = $(this);
        var tabTarget = $this.attr('href');

        $this.parent().addClass('active').siblings().removeClass('active');
        $(tabTarget).addClass('active').show().siblings('.tab-content').hide();
        if ($(tabTarget).hasClass('pricing-schedules')) {
          page.showFilterOptions();
        }
        return false;
      });
      $('.pricing-tab').on('click', function () {
        var tabTarget = $(this).attr('href');
        $(tabTarget).addClass('active').show().siblings('.tab-content').hide();
        $('body, html').animate({
          scrollTop: $(tabTarget).offset().top - 100
        }, 700);
        if ($(tabTarget).hasClass('pricing-schedules')) {
          page.showFilterOptions();
        }
        return false;
      });
    },
    dropdown: function () {
      var dropdown = $('.dropdown');
      var opener = dropdown.find('.dropdown-title');
      opener.on('click', function () {
        var $this = $(this);
        $this.closest('.dropdown').toggleClass('open').siblings('.dropdown').removeClass('open');
        dropdown.find('ul').jScrollPane({
          autoReinitialise: true
        });
      });
      $(document).on('click', function (event) {
        if ($(event.target).closest('.dropdown').length) return;
        dropdown.removeClass('open');
        event.stopPropagation();
      });
      $(document).on('mousewheel', function (event) {
        if ($(event.target).closest('.dropdown').length) return;
        dropdown.removeClass('open');
        event.stopPropagation();
      });
    },
    customScroll: function () {
      $('.scrollable').jScrollPane({
        autoReinitialise: true
      });
    },
    search: function () {
      var mainWrap = $('html');
      var searchPanel = $('.search-panel');
      var searchBtn = $('.search-btn');
      var closeBtn = searchPanel.find('.close-btn');
      searchBtn.on('click', function () {
        mainWrap.addClass('no-scroll');
        searchPanel.addClass('pullUp');
      });
      closeBtn.on('click', function () {
        mainWrap.removeClass('no-scroll');
        searchPanel.removeClass('pullUp');
      });
    },
    showFilterOptions: function () {
      var showMoreBtn = $('.filter .show-more');
      var optionList = $('.dropped');
      var option = optionList.find('li');
      var optionQty = option.length;
      var optionHeight = option.outerHeight(true);
      var optionListHeight = parseInt(optionQty * optionHeight);
      var fullHeight = false;
      if (optionQty < 3) {
        optionList.css('height', optionListHeight);
      }
      showMoreBtn.on('click', function () {
        if (fullHeight == false) {
          optionList.css('height', optionListHeight);
          showMoreBtn.text('show less cities');
          fullHeight = true;
        } else {
          optionList.removeAttr('style');
          showMoreBtn.text('show more cities');
          fullHeight = false;
        }
      });
    },
    subscribe: function () {
      //Mailchimp subscribe
      ajaxMailChimpForm($(".subscribe-form"), $(".subscribe-form .subscribe-result"));


      var elems  = $("#subscribe .form-row, #subscribe .subscribe-result");
      function ajaxMailChimpForm($form, $resultElement) {
        $form.submit(function (e) {
          e.preventDefault();
          if (!isValidEmail($form)) {
            var error = "A valid email address must be provided.";
            $resultElement.html(error);
            elems.addClass('wpcf7-not-valid');
          } else {
            $resultElement.html("Subscribing...");
            submitSubscribeForm($form, $resultElement);
            elems.removeClass('wpcf7-not-valid');
          }
        });
      }

      function isValidEmail($form) {
        var email = $form.find("input[type='text']").val();
        if (!email || !email.length) {
          elems.addClass('wpcf7-not-valid');
          return false;
        } else if (email.indexOf("@") == -1) {
          elems.addClass('wpcf7-not-valid');
          return false;
        }
        elems.removeClass('wpcf7-not-valid');
        return true;
      }

      function submitSubscribeForm($form, $resultElement) {
        $.ajax({
          type: "GET",
          url: $form.attr("action"),
          data: $form.serialize(),
          cache: false,
          dataType: "jsonp",
          jsonp: "c", // trigger MailChimp to return a JSONP response
          contentType: "application/json; charset=utf-8",
          error: function (error) {

          },
          success: function (data) {
            if (data.result != "success") {
              var message = data.msg || "Sorry. Unable to subscribe. Please try again later.";
              elems.addClass('wpcf7-not-valid');
              if (data.msg && data.msg.indexOf("already subscribed") >= 0) {
                message = "You're already subscribed. Thank you.";
              }
              $resultElement.html(message);
            } else {
              $resultElement.html("Please confirm the subscription in your inbox.");
              elems.removeClass('wpcf7-not-valid');
            }
          }
        });
      }
    },
    load: function () {
    },
    resize: function () {
    },
    scroll: function () {
      page.stickyHeader();
    }
  };

  $(document).ready(page.init);
  $(window).on({
    'load': page.load,
    'resize': page.resize,
    'scroll': page.scroll
  });

})(jQuery, window, document);
