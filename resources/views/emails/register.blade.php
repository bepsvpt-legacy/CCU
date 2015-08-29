<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>註冊驗證信</title>
    </head>
    <body>
        <main>
            <span>感謝您的註冊，請點擊下方連結以驗證您的信箱</span><br><br>

            {!! HTML::linkRoute('api.auth.verifyEmail', null, ['token' => $token]) !!}
        </main>
    </body>
</html>