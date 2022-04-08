@extends('core::layouts.backend')
@section('title', 'Themes')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Themes"> Themes</a></li>
@endsection
@push('css_stack')

@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row d-flex align-items-stretch">
            @foreach($themes as $theme)
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                    <div class="card bg-light">
                        <div class="card-header text-muted p-0" style="height: 247px">
                            <img src="{{ $theme->preview }}" alt="{{ $theme->name }}" class="img-thumbnail img-fluid img-cover">
                        </div>
                        <div class="card-body pt-2">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="lead text-ellipsis text-ellipsis-1l mb-2"><b>{{ $theme->name }}</b></h2>
                                    <p class="text-muted text-sm text-ellipsis text-ellipsis-2l">{{ $theme->description }}</p>
                                    <ul class="ml-3 mt-2 fa-ul text-muted">
                                        <li class="small">
                                            <i class="fa-li fa-sm fas fa-user"></i> {{ $theme->author }}
                                        </li>
                                        <li class="small">
                                            <i class="fa-li fa-sm fas fa-envelope"></i> {{ $theme->email }}
                                        </li>
                                        <li class="small">
                                            <i class="fa-li fa-sm fas fa-link"></i> {{ $theme->homepage }}
                                        </li>
                                        <li class="small">
                                            <i class="fa-li fa-sm fas fa-id-card"></i> {{ $theme->license }}
                                        </li>
                                        <li class="small">
                                            <i class="fa-li fa-sm fas fa-bookmark"></i> {{ $theme->version }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                @if ($theme_active == $theme->slug)
                                    <button type="button" class="btn btn-sm btn-success" disabled>
                                        <i class="fas fa-toggle-on"></i> Active
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-success setThemeEvent" data-theme-name="{{ $theme->slug }}" title="Set active this theme <br/> {{ $theme->name }}.">
                                        <i class="fas fa-toggle-off"></i> Set Active
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('js_stack')
    <script>
        let actionTheme = '{{ route('simple_cms.setting.backend.save_update') }}';
    </script>
    {!! module_script('theme', 'backend/js/index.js') !!}
@endpush
