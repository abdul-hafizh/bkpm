@extends('core::layouts.backend')
@section('title','Plugins')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Plugins"> Plugins</a></li>
@endsection
@push('css_stack')
    <style>
        table.table tr {
            border-left: 5px solid transparent;
        }
        table.table tr.active {
            border-left: 5px solid #00a0d2;
        }
    </style>
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">


                        <div class="card-tools">
                            <small>{{ count($plugins) }} items</small>
                        </div>
                    </div>
                    <div class="card-body pad table-responsive p-0">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th style="width: 30%;">Plugin</th>
                                <th style="width: 70%;">Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($plugins as $plugin)
                                <tr class="{{ ($plugin->isEnabled() ? 'active':'') }}">
                                    <td>
                                        <strong>{{ $plugin->__get('title') }}</strong>
                                        <br/>
                                        <div class="f-s-12">
                                            @if ($plugin->isEnabled())
                                                <a href="javascript:void(0);" class="eventChangeStatusPlugin" data-action="{{ route('simple_cms.plugin.backend.change_status', ['slug'=>$plugin->__get('slug'), 'status'=>'disable']) }}" title="Disabled">Disabled</a>
                                            @else
                                                <a href="javascript:void(0);" class="eventChangeStatusPlugin" data-action="{{ route('simple_cms.plugin.backend.change_status', ['slug'=>$plugin->__get('slug'), 'status'=>'enable']) }}" title="Enabled">Enabled</a>
                                            @endif
                                            @if ($plugin->__get('setting'))
                                                | <a href="{{ route('simple_cms.plugin.backend.setting', ['slug'=>$plugin->__get('slug')]) }}" title="Setting">Setting</a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-justify">
                                        {{ $plugin->__get('description') }}

                                        <div class="f-s-13 m-t-10">
                                            Version {{ $plugin->__get('version') }}
                                            | By <a {!! (!empty($plugin->__get('link_author')) ? 'href="'.$plugin->__get('link_author').'" target="_blank"' : 'href="javascript:void(0);"') !!} title="{{ $plugin->__get('author') }}">{{ $plugin->__get('author') }}</a>
                                            @if ($plugin->__get('detail'))
                                                | <a href="javascript:void(0);" title="View Detail">View details</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js_stack')
    {!! module_script('plugin', 'backend/js/index.js') !!}
@endpush
