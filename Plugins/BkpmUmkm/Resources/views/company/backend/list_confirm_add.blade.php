<div class="card">
    <div class="card-header">
        <h4 class="card-title">Ditemukan <strong>{{ $companies->total() }}</strong> @lang('label.company_ub')</h4>
    </div>
    <div class="card-body table-responsive">
        @if ($companies->count())
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr>
                    <th>No</th>
                    <th>@lang('label.name_company')</th>
                    <th>@lang('label.nib_company')</th>
                    <th>@lang('label.email')</th>
                    <th>@lang('wilayah::label.province')</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($companies as $k_c => $company)
                    <tr>
                        <td>{{ $k_c+1 }}.</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->nib?:'-' }}</td>
                        <td>{{ $company->email?:'-' }}</td>
                        <td>{{ ($company->provinsi ? $company->provinsi->nama_provinsi : '-') }}</td>
                        <td>
                            @if ($company->company_status)
                                <button type="button" class="btn btn-xs btn-warning"><i class="fas fa-ban"></i> @lang('label.company_already_registered')</button>
                            @else
                                <button type="button" class="btn btn-xs btn-success eventCompanyRegister" data-action="{{ route("{$bkpmumkm_identifier}.backend.company.confirm_add", ['event' => 'assign-new']) }}" data-value='@json(['company_id' => encrypt_decrypt($company->id), 'name_company' => $company->name, 'label_confirm' => __('label.confirmation_company_register')])'><i class="fas fa-sign-in-alt"></i> @lang('label.company_register')</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-center mt-3">
                <button type="button" onclick="window.location.href = '{{ route("{$bkpmumkm_identifier}.backend.company.add") }}'" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> @lang('label.add_new_company')</button>
            </div>
        @else
            <div class="text-center">
                <h4>@lang("label.data_not_found_create_new_company")</h4>
                <button type="button" onclick="window.location.href = '{{ route("{$bkpmumkm_identifier}.backend.company.add") }}'" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> @lang('label.add_new_company')</button>
            </div>
        @endif
    </div>
    @if($companies->hasPages())
        <div class="card-footer">
            {!! $companies->links() !!}
        </div>
    @endif
</div>
