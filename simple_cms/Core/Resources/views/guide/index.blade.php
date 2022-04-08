@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')

@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if(!$is_admin)
                    <div class="card">
                        <div class="card-body pad">
                            @if(!empty($file))
                                {!! shortcodes('[pdf_view src="'.$file.'"]') !!}
                            @else
                                <div class="alert alert-info">
                                    <h5><i class="icon fas fa-info"></i> {{ trans('label.guide_not_yet_available') }}</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    @foreach($groups as $group)
                        @php
                            $key_setting    = "guide_{$group->id}";
                            $file_guide     = simple_cms_setting($key_setting, '');
                            $group_name = str_replace([
                                                'Group', 'group', 'Groups', 'groups',
                                                'Roles', 'Role', 'roles', 'role',
                                                'Rules', 'rules', 'Rule', 'rule'
                                            ], '', $group->name);
                        @endphp
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">{{ trans('label.guide') }} {{ $group_name }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(!empty($file_guide))
                                    {!! shortcodes('[pdf_view src="'.$file_guide.'"]') !!}
                                @else
                                    <div class="alert alert-info">
                                        <h5><i class="icon fas fa-info"></i> {{ trans('label.guide_not_yet_available') }}</h5>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </div>
@endsection
@push('js_stack')

@endpush
