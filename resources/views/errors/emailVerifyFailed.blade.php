@extends('errors.master')

@section('title')
    <title>信箱驗證失敗</title>
@endsection

@section('main')
    <div class="title">信箱驗證失敗 - {{ $message }}</div>
    <div>{!! HTML::linkRoute('home', '點擊此處回首頁') !!}</div>
@endsection