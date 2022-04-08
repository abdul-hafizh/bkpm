<div class="modal-body">
    {!! $template !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">{{ trans('core::label.close') }}</button>
    @if (hasRoutePermission("{$bkpmumkm_identifier}.backend.umkm.massive.edit"))
        <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.umkm.massive.edit", ['id' => encrypt_decrypt($umkm->id)]) }}" title="{{ trans('label.edit_umkm') }}"><i class="fas fa-edit"></i> {{ trans('label.edit_umkm') }}</a>
    @endif
</div>
