@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_datatables('css') !!}
@endpush
@section('layout')
	<style>
		.nominal {
			position: relative;
			text-align: center;
		}
		.ub1 {
			position: absolute;
			top: 50%;
			left: 50%;
			color:#000;
		}
	</style>

    <div class="container-fluid nominal">
        <div class="row">
            <div class="col-md-12">
            	<img src="{{ url('uploads/section1.jpg') }}" width="100%" height="100%"/>
  				<div class="ub1">947</div>
            </div>
        </div>
		<div class="row">
            <div class="col-md-12">
            	<img src="{{ url('uploads/section2.jpg') }}" width="100%" height="100%"/>
            </div>
        </div>
    </div>
@endsection
