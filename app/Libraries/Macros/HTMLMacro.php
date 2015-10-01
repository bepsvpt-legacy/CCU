<?php

/**
 * Render facebook login image.
 *
 * @return string
 */
HTML::macro('loginWithFacebook', function() {
    return sprintf('<div class="text-center"><hr><a href="%s"><img src="https://cdn.bepsvpt.net/images/login-with-fb.png" alt="Login with Facebook" class="shadow-z-1"></a></div>', e(route('api.auth.facebook.signIn')));
});
