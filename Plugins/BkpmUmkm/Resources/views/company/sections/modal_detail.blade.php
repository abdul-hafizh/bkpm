<div class="modal-body">
    {!! $template !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">{{ trans('core::label.close') }}</button>
    @if (hasRoutePermission("{$bkpmumkm_identifier}.backend.company.edit"))
        <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.company.edit", ['id' => encrypt_decrypt($company->id)]) }}" title="{{ trans('label.edit_company') }}"><i class="fas fa-edit"></i> {{ trans('label.edit_company') }}</a>
    @endif
</div>
