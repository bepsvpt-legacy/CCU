<?php

/**
 * Render form validation message.
 *
 * @return string
 */
Form::macro('validationMessage', function() {
    return '<span class="form-control-feedback" aria-hidden="true"></span><div class="help-block with-errors text-center"></div>';
});

/**
 * Render Google recaptcha.
 *
 * @return string
 */
Form::macro('recaptcha', function() {
    return sprintf(
        '<div id="g-recaptcha" data-sitekey="%s" data-size="%s"></div>',
        env('RECAPTCHA_SITE_KEY', ''),
        Agent::isMobile() ? 'compact' : 'normal'
    );
});
