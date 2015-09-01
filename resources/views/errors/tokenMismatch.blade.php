@extends('errors.master')

@section('main')
    <div class="title">很抱歉，基於安全性的考量，此次操作已被中斷</div>
    <div><a href="{{ route('home') }}">回首頁</a></div>
@endsection