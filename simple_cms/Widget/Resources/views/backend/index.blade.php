@extends('core::layouts.backend')
@section('title', 'Widgets')
@push('css_stack')
    {!! module_style('widget', 'backend/css/index.css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                <div class="card card-widget">
                    <div class="card-header">
                        <h4 class="f-w-400 m-b-2">Available Widgets</h4>
                        <small class="text-muted">To activate a widget drag it to a sidebar. To deactivate a widget and delete its settings, drag it back.</small>
                    </div>
                    <div class="card-body p-r-5 p-l-5">
                        <div class="row widgets-available">
                            @foreach(Widget::getWidgets() as $widget)
                                <div data-id="{{ $widget->getId() }}" class="col-xs-12 col-sm-12 col-md-6 col-lg-6 widgets-drag widgets-item">
                                    <div class="card card-widget collapsed-card">
                                        <div class="card-header cursor-move">
                                            <strong class="f-w-400 m-b-2 f-s-15">{{ $widget->getConfig()['name'] }}</strong>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>

                                        <div class="card-body p-5">
                                            <form>
                                                <input type="hidden" name="id" value="{{ $widget->getId() }}">
                                                {!! $widget->formSetting() !!}
                                                <div class="row">
                                                    <div class="col-lg-6 text-left">
                                                        <button type="button" class="btn btn-danger btn-xs eventDeleteWidget" title="Delete this widget {{ $widget->getConfig()['name'] }}"><i class="fas fa-trash"></i> </button>
                                                    </div>
                                                    <div class="col-lg-6 text-right">
                                                        <button type="submit" class="btn btn-primary btn-xs eventSaveWidget" title="Save this widget {{ $widget->getConfig()['name'] }}"><i class="fas fa-save"></i> </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="widgets-description">
                                        <small>{{ $widget->getConfig()['description'] }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-7">
                <div class="row">
                    @foreach(WidgetGroup::getGroups() as $group)
                        <div class="col-lg-6">
                            <div class="card card-widget">
                                <div class="card-header">
                                    <h4 class="f-w-400 m-b-2">{{ $group->getName() }}</h4>
                                    <small class="text-muted">{{ $group->getDescription() }}</small>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-r-5 p-l-5">
                                    <div data-group="{{ $group->getId() }}" class="row widgets-clone" style="min-height: 50px;">

                                        @foreach($group->getWidgets() as $item)
                                            @if (class_exists($item->widget_id, false))
                                                @php $widget = new $item->widget_id; @endphp
                                                <div data-id="{{ $widget->getId() }}" class="col-xs-12 col-sm-12 widgets-added widgets-item">
                                                    <div class="card card-widget collapsed-card">
                                                        <div class="card-header cursor-move">
                                                            <strong class="f-w-400 m-b-2 f-s-15">{{ $widget->getConfig()['name'] }}</strong>
                                                            <div class="card-tools">
                                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                                                            </div>
                                                        </div>

                                                        <div class="card-body p-5">
                                                            <form>
                                                                <input type="hidden" name="id" value="{{ $widget->getId() }}">
                                                                {!! $widget->formSetting($item->group, $item->position) !!}
                                                                <div class="row">
                                                                    <div class="col-lg-6 text-left">
                                                                        <button type="button" class="btn btn-danger btn-xs eventDeleteWidget" title="Delete this widget {{ $widget->getConfig()['name'] }}"><i class="fas fa-trash"></i> </button>
                                                                    </div>
                                                                    <div class="col-lg-6 text-right">
                                                                        <button type="button" class="btn btn-primary btn-xs eventSaveWidget" title="Save this widget {{ $widget->getConfig()['name'] }}"><i class="fas fa-save"></i> </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="widgets-description">
                                                        <small>{{ $widget->getConfig()['description'] }}</small>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js_stack')
    <script>
        const widgets = { routes: { save: "{{ route('simple_cms.widget.backend.save') }}", delete: "{{ route('simple_cms.widget.backend.delete') }}" } };
    </script>
    {!! module_script('widget', 'backend/js/index.js') !!}
@endpush
