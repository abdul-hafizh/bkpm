{!! library_datepicker('css') !!}
@coreStyles()
@coreScriptsTop()
<form id="formDownloadBeritaAcara" data-action="{{ route("{$bkpmumkm_identifier}.backend.survey.download_berita_acara", ['company' => $category_company, 'survey'=>encrypt_decrypt($survey->id), 'page' => 'request-download']) }}">
    <div class="modal-body">
        <div class="form-group">
            <label for="date_berita_acara">{{ trans('label.berita_acara_date') }}</label>
            <input id="date_berita_acara" name="date_survey" class="form-control datepickerInit" placeholder="{{ trans('label.berita_acara_date') }}" required>
        </div>
        <div class="form-group">
            <label for="company_name_berita_acara">{{ trans('label.berita_acara_company_name') }}</label>
            <input id="company_name_berita_acara" name="company_name" value="{{ $survey->{$category_company}->name }}" placeholder="{{ trans('label.berita_acara_company_name') }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="company_address_berita_acara">{{ trans('label.berita_acara_company_address') }}</label>
            <textarea id="company_address_berita_acara" name="company_address" class="form-control" placeholder="{{ trans('label.berita_acara_company_address') }}">{!! nl2br($survey->{$category_company}->address) !!}</textarea>
        </div>
        {!!
            template_wilayah_negara(
                $survey->{$category_company}->id_negara,
                $survey->{$category_company}->id_provinsi,
                $survey->{$category_company}->id_kabupaten,
                $survey->{$category_company}->id_kecamatan,
                $survey->{$category_company}->id_desa
            )
        !!}

        <div class="form-group">
            <label for="wilayah_berita_acara">{{ trans('label.berita_acara_provinsi_signature') }}</label>
            <select id="wilayah_berita_acara" name="province_signature" class="form-control" required>
                @foreach ($provinsi as $prov)
                    <option value="{{ $prov->kode_provinsi }}" {{ ($prov->kode_provinsi == auth()->user()->id_provinsi ? 'selected' : '') }}>{{ $prov->nama_provinsi }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="date_signature_berita_acara">{{ trans('label.berita_acara_date_signature') }}</label>
            <input id="date_signature_berita_acara" name="date_signature" class="form-control datepickerInit" placeholder="{{ trans('label.berita_acara_date_signature') }}" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">{{ trans('label.cancel') }}</button>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-download"></i> {{ trans('label.download') }}</button>
    </div>
</form>
{!! library_datepicker('js') !!}
@coreScripts()
