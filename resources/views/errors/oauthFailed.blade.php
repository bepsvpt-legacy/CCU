@extends('errors.master')

@section('title')
    <title>驗證失敗</title>
@endsection

@section('main')
    <div class="title">很抱歉，{{ $message or '似乎出了點狀況' }}</div>
    @if ($invalidEmail)
        <div>請至 <a href="https://www.facebook.com/settings?tab=applications" target="_blank">Facebook 應用程式頁面</a> 移除本程式(Changin' CCU)後，再嘗試登入</div><br>
    @endif
    <div><a href="{{ session()->previousUrl() }}">重新登入</a></div>
@endsection