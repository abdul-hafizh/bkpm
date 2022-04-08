@extends('core::layouts.backend')
@section('title','Translation')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Translation"> Translation</a></li>
@endsection
@push('css_stack')
    {!! library_datatables('css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Language / Locale @if(hasRoutePermission('simple_cms.translation.backend.language.add')) <button type="button" class="btn btn-sm btn-info show_modal_sm" data-action="{{ route('simple_cms.translation.backend.language.add') }}" data-method="POST" data-value="" title="New Language"><i class="fas fa-plus"></i> New Language</button> @endif </h4>
                            </div>
                            <div class="card-body pad p-0">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Locale</th>
                                            <th>Name</th>
                                            <th style="width: 5%;"></th>
                                            <th style="width: 10%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($locales as $locale)
                                            <tr class="{{ ($locale->trashed() ? 'bg-trashed':'') }}">
                                                <td>{{ $locale->locale }}</td>
                                                <td>{{ $locale->name }}</td>
                                                <td>
                                                    @if($default_locale == $locale->locale)
                                                        <span class="text-success" title="Default Language"><i class="fas fa-check-square"></i> </span>
                                                    @else
                                                        <span class="pointer-cursor eventSetDefaultLanguage" data-action="{{ route('simple_cms.translation.backend.language.set_default') }}" data-value='@json(['settings' => ['locale' => $locale->locale]])' title="Set Default Language: {{ $locale->locale .' [ ' . $locale->name . ' ]' }}"><i class="far fa-square"></i> </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(hasRoutePermission('simple_cms.translation.backend.language.edit') && !$locale->trashed())
                                                        <button type="button" class="btn btn-xs btn-warning show_modal_sm" data-action="{{ route('simple_cms.translation.backend.language.edit') }}" data-method="POST" data-value='@json(['id' => encrypt_decrypt($locale->id)])' title="Edit Language: {{ $locale->locale .' [ ' . $locale->name . ' ]' }}"><i class="fas fa-edit"></i></button>
                                                    @endif
                                                    @if(hasRoutePermission('simple_cms.translation.backend.language.restore') && $locale->trashed())
                                                        <button type="button" class="btn btn-xs btn-info eventLanguageRestore" data-action="{{ route('simple_cms.translation.backend.language.restore') }}" data-method="POST" data-value='@json(['id' => encrypt_decrypt($locale->id)])' title="Restore Language: {{ $locale->locale .' [ ' . $locale->name . ' ]' }}"><i class="fas fa-refresh"></i></button>
                                                    @endif
                                                    @if(hasRoutePermission('simple_cms.translation.backend.language.soft_delete') && !$locale->trashed() && ($default_locale !== $locale->locale) )
                                                        <button type="button" class="btn btn-xs btn-danger eventLanguageTrash" data-action="{{ route('simple_cms.translation.backend.language.soft_delete') }}" data-method="DELETE" data-value='@json(['id' => encrypt_decrypt($locale->id)])' title="Trash Language: {{ $locale->locale .' [ ' . $locale->name . ' ]' }}"><i class="fas fa-trash"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body pad">
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('js_stack')
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
    {!! module_script('core','js/events.js') !!}
    {!! module_script('translation','js/index.js') !!}
    {!! module_script('translation', 'js/language.js') !!}
    {!! module_script('translation', 'js/translation.js') !!}
@endpush
