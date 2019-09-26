    @if(($items = app('larakuy.backend.menu')->roots()) && (!$items->isEmpty()))
        @include('layouts.backend.sidebar_item', ['items' => $items])
    @endif
