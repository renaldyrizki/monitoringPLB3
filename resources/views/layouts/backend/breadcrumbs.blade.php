@if ($breadcrumbs)
	<ol class="breadcrumb">
		@foreach ($breadcrumbs as $breadcrumb)
			@if ($breadcrumb->url && !$breadcrumb->last)
				<li><a href="{{ $breadcrumb->url }}">
                    @if(!empty($breadcrumb->icon))
                    <i class="{{ $breadcrumb->icon }}"></i>
                    @endif
                    {{ $breadcrumb->title }}
                </a></li>
			@else
				<li class="active">
                    @if(!empty($breadcrumb->icon))
                    <i class="{{ $breadcrumb->icon }}"></i>
                    @endif
                    {{ $breadcrumb->title }}
                </li>
			@endif
		@endforeach
	</ol>
@endif