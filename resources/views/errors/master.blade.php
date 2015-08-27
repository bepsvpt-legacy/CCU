<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title', 'Oops! There is something wrong!')</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <style>html,body{height:100%}body{margin:0;padding:0;width:100%;color:#B0BEC5;display:table;font-weight:100;font-family:'Lato'}a{text-decoration:none}.container{text-align:center;display:table-cell;vertical-align:middle}.content{text-align:center;display:inline-block}.title{font-size:36px;margin-bottom:24px}</style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                @yield('main')
            </div>
        </div>
    </body>
</html>