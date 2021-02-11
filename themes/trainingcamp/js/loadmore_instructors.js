(function ($, window, document) {
    "use strict";

    $.fn.loadmore_scroll = function (options) {
        // reset
        $(window).unbind('loadmore_start');

        var options = $.extend({
                nextSelector: false,
                navSelector: false,
                itemSelector: false,
                contentSelector: false,
                maxPage: false,
                loader: false
            }, options),
            loading = false,
            finished = false,
            nextpage_url = $(options.nextSelector).attr('href'); // init next url
        // validate options and hide navigation
        if ($(options.nextSelector).length && $(options.navSelector).length && $(options.itemSelector).length && $(options.contentSelector).length) {
            $(options.navSelector).hide();
        }
        else {
            // set finished true
            finished = true;
        }

        var load_posts = function () {
            var last_elem = $(options.contentSelector).find(options.itemSelector).last();
            // set loader and loading
            if (options.loader)
                $(options.loader).show();
            loading = true;

            $.ajax({
                url: nextpage_url,
                dataType: 'html',
                success: function (data) {
                    var obj = $(data),
                        elem = obj.find(options.itemSelector),
                        next = obj.find(options.nextSelector);

                    if (next.length) {
                        nextpage_url = next.attr('href');
                    }
                    else {
                        finished = true;
                    }

                    last_elem.after(elem);

                    if (options.loader)
                        $(options.loader).hide();

                    $(document).trigger('loadmore_adding_elem');

                    elem.addClass('loadmore-animated');


                    setTimeout(function () {
                        loading = false;
                        elem.removeClass('loadmore-animated');
                        $(document).trigger('loadmore_added_elem');
                    }, 0);

                }
            });


        };
        // scroll event
        $(window).on('scroll touchstart', function () {
            $(this).trigger('loadmore_start');
        });


        $(window).on('loadmore_start', function () {
            var w = $(this),
                offset = $(options.itemSelector).last().offset();
            if (!loading && !finished && w.scrollTop() >= Math.abs(offset.top - ( w.height() - 50 ))) {
                load_posts();
            }
        })
    }
})(jQuery, window, document);

$(document).ready(function ($) {
    "use strict";
    // set options
    var loadmore_scroll = {
        'nextSelector': 'a.nextpostslink',
        'navSelector': '.wp-pagenavi',
        'itemSelector': '.instructor',
        'contentSelector': '.instructors'
    };
    $('.instructors').loadmore_scroll(loadmore_scroll);
});