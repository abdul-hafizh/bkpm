@if (hasRoutePermission($route_name_action))
    @php
        $key_random = \Str::random(7);
    @endphp
    <form data-action="{{ route($route_name_action) }}" class="formImportDataTable col-xs-12 col-sm-12 col-md-6 col-lg-6" data-random="{{ $key_random }}">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="import_datatable">{{ trans('label.import') }} (xls,xlsx)</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="import_datatable_{{ $key }}" required>
                            <label class="custom-file-label" for="import_datatable_{{ $key }}">Choose file</label>
                        </div>
                    </div>
                    <div class="progress progress-sm progress-upload d-none">
                        <div class="progress-bar bg-info progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                            <span class="progress-upload-text">0%</span>
                        </div>
                    </div>
                </div>
                @if (!empty($link_download_template))
                    <div class="form-group">
                        {!! download($link_download_template, $title_filename_download, $download_template_must_login) !!}
                    </div>
                @endif
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-sm btn-primary" title="{{ trans('label.import') }}"><i class="fas fa-file-import"></i> {{ trans('label.import') }}</button>
            </div>
        </div>
    </form>
    <div class="formImportSingleMessage_{{ $key_random }} col-xs-12 col-sm-12 col-md-6 col-lg-6">

    </div>
@endif
