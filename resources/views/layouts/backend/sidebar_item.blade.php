        @foreach($items as $item)
            @if($item->hasChildren())
                <?php
                $active = '';
                foreach($item->children() as $children){
                    if(Request::url()==$children->url()){
                        $active = ' active';
                        break;
                    }
                }
                ?>
                <li class="treeview{{ $active }}">
                    <a href="#">
                        @if($item->data('icon'))
                            <i class="fa {{ $item->data('icon') }}"></i> 
                        @endif
                        <span>{!! $item->title !!}</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @include('layouts.backend.sidebar_item', ['items' => $item->children()])
                    </ul>
                </li>
            @else
                <li class="{{ $active = (Request::url()==$item->url()) ? 'active' : ''}}">
                    <a href="{{ $item->url() }}">
                        @if($item->data('icon'))
                            <i class="fa {{ $item->data('icon') }}"></i> 
                        @endif
                        {!! $item->title !!}
                    </a>
                </li>
            @endif

        @endforeach