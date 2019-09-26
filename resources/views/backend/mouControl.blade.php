@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('mouControl') !!}
@endsection

@section('content')
    Welcome {{ Auth::user()->name }}
@endsection