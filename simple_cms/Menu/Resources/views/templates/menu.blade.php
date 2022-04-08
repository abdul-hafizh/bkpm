@foreach ($items as $item)
	@if ($item->hasChilds())
		@include('menu::templates.item.dropdown', compact('item'))
	@else
		@include('menu::templates.item.item', compact('item'))
	@endif
@endforeach
