@extends('acl::user.user-management')
@section('title','Activity Log')
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="Activity Log"> Activity Log</a></li>
@endsection

@push('css_stack')
    {!! library_datatables('css') !!}
@endpush
@section('partial')
    {!! $dataTable->table() !!}
@endsection
@push('js_stack')
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
@endpush
