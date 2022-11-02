@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.target.index") }}" title="Target"> Target</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')

@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3 justify-content-center">
            <div class="col-5">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.target.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
                @if($target->id)
                    <a class="btn btn-primary btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.target.add") }}" title="Tambah Target Baru"><i class="fa fa-plus"></i> Tambah Target Baru</a>
                @endif
            </div>
        </div>

        <form id="formAddEditTarget" class="row justify-content-center" data-action="{{ route("{$bkpmumkm_identifier}.backend.target.save_update") }}">
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ encrypt_decrypt($target->id) }}" />
                        <div class="form-group">
                            <label for="target_UB">Target UB <i class="text-danger">*</i></label>
                            <input id="target_UB" type="number" name="target_UB" value="{{ $target->target_UB }}" class="form-control" required>
                        </div>                        
                        <div class="form-group">
                            <label for="target_umkm">Target UMKM <i class="text-danger">*</i></label>
                            <input id="target_umkm" type="number" name="target_umkm" value="{{ $target->target_umkm }}" class="form-control" required>
                        </div>                        
                        <div class="form-group">
                            <label for="target_value">Target Value <i class="text-danger">*</i></label>
                            <input id="target_value" type="number" name="target_value" value="{{ $target->target_value }}" class="form-control" required>
                        </div>                        
                        <div class="form-group">
                            <label for="tahun">Tahun <i class="text-danger">*</i></label>
                            <input id="tahun" type="text" maxlength="4" name="tahun" value="{{ $target->tahun }}" class="form-control" required>
                        </div>                        
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-sm" title="{{ trans('label.save') }}"><i class="fa fa-save"></i> {{ trans('label.save') }}</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@push('js_stack')
    <script>
        /*
        * Created By : Ahmad Windi Wijayanto
        * Email : ahmadwindiwijayanto@gmail.com
        * website : https://whendy.net
        * --------- 3/19/20, 3:06 PM ---------
        */

        $(document).ready(function () {

            $(document).on('submit','#formAddEditTarget',function (e) {
                e.preventDefault();
                let url = $(this).attr('data-action'),
                    params = $(this).serialize();

                $.ajax({
                    url: url, type: 'POST', typeData: 'json', cache: false, data: params,
                    success: function (res) {
                        simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(res);
                    }
                });
            });
        });

    </script>
@endpush
