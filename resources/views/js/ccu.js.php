(function ($) {
    $(function () {
        'use strict';

        if ( ! window.location.hash)
        {
            window.location.hash = '#/';
        }

        $.material.init();
        $('[data-toggle="tooltip"]').tooltip();

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