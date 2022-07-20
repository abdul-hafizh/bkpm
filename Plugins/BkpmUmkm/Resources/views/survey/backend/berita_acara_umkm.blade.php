<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>{{ trans('label.photo_scan_berita_acara') }}</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="exampleInputFile" accept=".jpg,.jpeg,.png,.pdf">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png, .pdf</span>
                <div class="row">
                    @if ($survey->survey_result&&!empty($survey->survey_result->documents)&&isset($survey->survey_result->documents['file']))
                        <input type="hidden" name="file_old" value="{{ $survey->survey_result->documents['file'] }}">
                        <div class="col-lg-6 col-md-6 col-12">
                            <a href="{{ asset($survey->survey_result->documents['file']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($survey->survey_result->documents['file'])) }}">
                                <img class="img-fluid img-thumbnail" src="{{ view_asset($survey->survey_result->documents['file']) }}">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group">
                    <label>Foto Evidance Survey</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="photo" class="custom-file-input" id="exampleInputFilePhoto" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="exampleInputFilePhoto">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png</span>
                <div class="row">
                    @if ($survey->survey_result&&!empty($survey->survey_result->documents)&&isset($survey->survey_result->documents['photo']))
                        <input type="hidden" name="photo_old" value="{{ $survey->survey_result->documents['photo'] }}">
                        <div class="col-lg-6 col-md-6 col-12">
                            <a href="{{ asset($survey->survey_result->documents['photo']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($survey->survey_result->documents['photo'])) }}">
                                <img class="img-fluid img-thumbnail" src="{{ view_asset($survey->survey_result->documents['photo']) }}">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary btn-sm" title="{{ trans('label.save') }}"><i class="fa fa-save"></i> {{ trans('label.save') }}</button>
    </div>
</div>
