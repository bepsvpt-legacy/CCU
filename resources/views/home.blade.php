<!DOCTYPE html>
<html ng-app="ccu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CCU</title>
        <noscript><meta http-equiv="refresh" content="0; url=/errors/noscript"></noscript>
        <script>const VERSION = {{ $version }};</script>
        <style>
            #ccu-initializing{position:fixed;top:50%;left:50%;margin-top:-164px;margin-left:-32px;z-index:99999}#ccu-initializing .background{position:fixed;top:0;left:0;min-width:100%;min-height:100%;background:#eee}.hide{display:none!important}body{overflow-y:scroll!important}
            /* http://tobiasahlin.com/spinkit/ */
            .ccu-initializing-spinner{width:64px;height:64px;background-color:#ff6a07;margin:100px auto;-webkit-animation:ccu-initializing-sk-rotateplane 1.2s infinite ease-in-out;animation:ccu-initializing-sk-rotateplane 1.2s infinite ease-in-out}@-webkit-keyframes ccu-initializing-sk-rotateplane{0{-webkit-transform:perspective(120px)}50%{-webkit-transform:perspective(120px) rotateY(180deg)}100%{-webkit-transform:perspective(120px) rotateY(180deg) rotateX(180deg)}}@keyframes ccu-initializing-sk-rotateplane{0{transform:perspective(120px) rotateX(0) rotateY(0);-webkit-transform:perspective(120px) rotateX(0) rotateY(0)}50%{transform:perspective(120px) rotateX(-180.1deg) rotateY(0);-webkit-transform:perspective(120px) rotateX(-180.1deg) rotateY(0)}100%{transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg);-webkit-transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg)}}
        </style>
        <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/material-fullpalette.min.css">
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/ripples.min.css">
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular-loading-bar/0.8.0/loading-bar.min.css">
        <link type="text/css" rel="stylesheet" href="{{ (app()->environment(['production'])) ? 'https://cdn.bepsvpt.net/css/ccu.min.css' : routeAssets('css.ccu') . "?{$version}" }}">
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