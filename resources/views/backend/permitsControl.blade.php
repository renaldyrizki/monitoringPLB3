@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('permitsControl') !!}
@endsection

@section('content')
    Welcome {{ Auth::user()->name }}
@endsection