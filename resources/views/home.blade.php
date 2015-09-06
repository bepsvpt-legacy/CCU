<!DOCTYPE html>
<html ng-app="ccu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CCU</title>
        <noscript><meta http-equiv="refresh" content="0; url=/errors/noscript"></noscript>
        <script>
            const VERSION = 1.2;

            (function () {
                'use strict';

                if (VERSION > parseFloat(localStorage.getItem('VERSION') || 0)) {
                    localStorage.setItem('VERSION', VERSION);
                    window.location.reload(true);
                }
            })();
        </script>
        <style>
            #ccu-initializing{position:fixed;top:50%;left:50%;margin-top:-164px;margin-left:-32px;z-index:99999}#ccu-initializing .background{position:fixed;top:0;left:0;min-width:100%;min-height:100%;background:#eee}.hide{display:none!important}body{overflow-y:scroll!important}
            /* http://tobiasahlin.com/spinkit/ */
            .ccu-initializing-spinner{width:64px;height:64px;background-color:#ff6a07;margin:100px auto;-webkit-animation:ccu-initializing-sk-rotateplane 1.2s infinite ease-in-out;animation:ccu-initializing-sk-rotateplane 1.2s infinite ease-in-out}@-webkit-keyframes ccu-initializing-sk-rotateplane{0{-webkit-transform:perspective(120px)}50%{-webkit-transform:perspective(120px) rotateY(180deg)}100%{-webkit-transform:perspective(120px) rotateY(180deg) rotateX(180deg)}}@keyframes ccu-initializing-sk-rotateplane{0{transform:perspective(120px) rotateX(0) rotateY(0);-webkit-transform:perspective(120px) rotateX(0) rotateY(0)}50%{transform:perspective(120px) rotateX(-180.1deg) rotateY(0);-webkit-transform:perspective(120px) rotateX(-180.1deg) rotateY(0)}100%{transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg);-webkit-transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg)}}
        </style>
    </head>
    <body>
        <div id="ccu-initializing"><div class="background"></div><div class="ccu-initializing-spinner"></div></div>

        <div class="hide">
            @include('layouts.header')

            <main class="container" ui-view></main>

            @include('layouts.footer')
        </div>

        @include('layouts.errorsModal')

        @include('layouts.scripts')
    </body>
</html>