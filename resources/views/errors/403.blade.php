@extends('errors.master')

@section('title')
    <title>403 Forbidden</title>
@endsection

@section('main')
    <div class="title">您沒有權限瀏覽此頁面</div>
    <div>
        <a href="/#/auth/sign-in">登入以繼續</a>
        <span> 或 </span>
        <a href="/#/auth/register">註冊新帳號</a>
    </div>
@endsection