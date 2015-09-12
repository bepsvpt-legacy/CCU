<?php

/**
 * Render form validation message.
 *
 * @return string
 */
Form::macro('validationMessage', function()
{
    return '<span class="form-control-feedback" aria-hidden="true"></span><div class="help-block with-errors text-center"></div>';
});

/**
 * Render Google recaptcha.
 *
 * @return string
 */
Form::macro('recaptcha', function()
{
    $siteKey = env('RECAPTCHA_SITE_KEY');

    $size = Agent::isMobile() ? 'compact' : 'normal';

    return "<div id='g-recaptcha' data-sitekey='{$siteKey}' data-size='{$size}'></div>";
});
