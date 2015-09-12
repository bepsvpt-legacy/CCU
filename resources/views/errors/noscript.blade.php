@extends('errors.master')

@section('title')
    <title>未啟用 JavaScript</title>
    <script>window.location.replace('/');</script>
@endsection

@section('main')
    <div class="title">很抱歉，為了獲得最佳的體驗，請啟用 JavaScript</div>
    <div>啟用後，請嘗試按下 Ctrl+F5 以避免因快取而倒置仍顯示此錯誤</div><br>
    <div>如您使用的瀏覽器並不支援 JavaScript，在此推薦您使用 <a href="https://www.google.com.tw/chrome/browser/desktop/" target="_blank">Chrome</a> 瀏覽器</div>
@endsection