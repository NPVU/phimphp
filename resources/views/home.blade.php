@extends('layouts.app')
@section('title')
    Trang chủ - {{ config('app.name') }}
@endsection
@section('slider')
    @include('layouts.slider')
@endsection
@section('hot')
    @include('layouts.hot')
@endsection