@extends('errors.master')

@section('title')
    <title>404 Not Found</title>
@endsection

@section('main')
    <div class="title">唉呦，這個頁面不見啦，{!! HTML::linkRoute('home', '只能回首頁了') !!}</div>
@endsection