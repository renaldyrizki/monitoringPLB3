@php
    $user = Auth::user();
@endphp

@if(($items = app('larakuy.backend.menu')->roots()) && (!$items->isEmpty()) && $user->isAdmin==1 )
    @include('layouts.backend.sidebar_item', ['items' => $items])
@endif

@if(($items = app('larakuy.user.menu')->roots()) && $user->isAdmin==0 )
    @include('layouts.backend.sidebar_item', ['items' => $items])
@endif