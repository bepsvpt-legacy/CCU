'use strict';

(function ($) {
    /*!
     loadCSS: load a CSS file asynchronously.
     [c]2015 @scottjehl, Filament Group, Inc.
     Licensed MIT
     */
    function loadCSS(f,c,g){var b=window.document.createElement("link"),a;c?a=c:window.document.querySelectorAll?(a=window.document.querySelectorAll("style,link[rel=stylesheet],script"),a=a[a.length-1]):a=window.document.getElementsByTagName("script")[0];var e=window.document.styleSheets;b.rel="stylesheet";b.href=f;b.media="only x";a.parentNode.insertBefore(b,c?a:a.nextSibling);b.onloadcssdefined=function(a){for(var c,d=0;d<e.length;d++)e[d].href&&e[d].href===b.href&&(c=!0);c?a():setTimeout(function(){b.onloadcssdefined(a)})}; b.onloadcssdefined(function(){b.media=g||"all"});return b};

    $(function () {
        var needLoadCss = [
            'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
            'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css',
            'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/material-fullpalette.min.css',
            'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/ripples.min.css',
            'https://cdnjs.cloudflare.com/ajax/libs/angular-loading-bar/0.8.0/loading-bar.min.css',
            '{{ routeAssets("css.ccu") }}'
        ];

        window.onload = function () {
            setTimeout(function() {
                $.material.init();
                $('[data-toggle="tooltip"]').tooltip();

                if (window.matchMedia('(max-width: 768px)').matches) {
                    $('header [data-toggle="tooltip"]').tooltip('destroy');
                }

                $('#ccu-initializing').fadeOut(250, function () {
                    $(this).next('div.hide').removeClass('hide');
                    $(this).remove();
                });
            }, 450);
        };

        if ( ! window.location.hash) {
            window.location.hash = '#/';
        }

        for (var i in needLoadCss) {
            if (needLoadCss.hasOwnProperty(i)) {
                loadCSS(needLoadCss[i]);
            }
        }

        $(document).on('click', 'header nav.navbar a', function () {
            $('button[data-toggle="collapse"][data-target="#navbar-collapse"][aria-expanded="true"]').click();
        });

        $(document).arrive('form[data-toggle="validator"]', function () {
            $(this).validator({feedback: {success: 'fa fa-check', error: 'fa fa-remove'}, delay: 2500});
        });

        $(document).arrive('[data-toggle="tooltip"]', function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(document).arrive('textarea', function () {
            autosize($('textarea'));
        });

        $(document).arrive('#g-recaptcha', function () {
            var r = $('#g-recaptcha');
            grecaptcha.render('g-recaptcha', {sitekey: r.data('sitekey'), size: r.data('size')});
        });
    });
})(jQuery);