<!DOCTYPE html>
<html ng-app="ccu" ng-csp="no-unsafe-eval">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Changin' CCU</title>
        <noscript><meta http-equiv="refresh" content="0; url=/errors/noscript"></noscript>
        <script>const VERSION = {{ $version }};</script>
        <style>#ccu-initializing{position:fixed;top:50%;left:50%;margin:-4em 0 0 -2em;z-index:99999}#ccu-initializing .background{position:fixed;top:0;left:0;min-width:100%;min-height:100%;background:#eee}#ccu-initializing span{color:orange}body{overflow-y:scroll!important}</style>
        <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>
        <div id="ccu-initializing"><div class="background"></div><span class="fa fa-spinner fa-pulse fa-4x" aria-hidden="true"></span></div>

        <div class="hide">
            @include('layouts.header')

            <main class="container" ui-view></main>

            @include('layouts.footer')
        </div>

        <toaster-container></toaster-container>

        @include('layouts.errorsModal')

        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/material-fullpalette.min.css">
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/ripples.min.css">
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular-loading-bar/0.8.0/loading-bar.min.css">
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angularjs-toaster/0.4.15/toaster.min.css">
        <link type="text/css" rel="stylesheet" href="{{ ((app()->environment(['production'])) ? 'https://cdn.bepsvpt.net/css/ccu.min.css' : routeAssets('css.ccu')) . "?v={$version}" }}">

        @include('layouts.scripts')
    </body>
</html>