@extends('errors.master')

@section('title')
    <title>403 Forbidden</title>
@endsection

@section('main')
    <div class="title">您沒有權限瀏覽此頁面，{!! HTML::linkRoute('home', '回首頁') !!}</div>
@endsection