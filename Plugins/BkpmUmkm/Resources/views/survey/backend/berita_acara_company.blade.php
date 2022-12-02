<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>{{ trans('label.surat_ketersediaan_bermitra_1') }}</label>
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
                    <label>{{ trans('label.surat_ketersediaan_bermitra_2') }}</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="photo" class="custom-file-input" id="exampleInputFilePhoto" accept=".jpg,.jpeg,.png,.pdf">
                        <label class="custom-file-label" for="exampleInputFilePhoto">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png, .pdf</span>
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
            <div class="col-12 mt-4">
                <div class="form-group">
                    <label>Foto Evidance Survey 1</label>
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
            <div class="col-12 mt-4">
                <div class="form-group">
                    <label>Foto Evidance Survey 2</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="photo2" class="custom-file-input" id="exampleInputFilePhoto" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="exampleInputFilePhoto">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png</span>
                <div class="row">
                    @if ($survey->survey_result&&!empty($survey->survey_result->documents)&&isset($survey->survey_result->documents['photo2']))
                        <input type="hidden" name="photo_old2" value="{{ $survey->survey_result->documents['photo2'] }}">
                        <div class="col-lg-6 col-md-6 col-12">
                            <a href="{{ asset($survey->survey_result->documents['photo2']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($survey->survey_result->documents['photo2'])) }}">
                                <img class="img-fluid img-thumbnail" src="{{ view_asset($survey->survey_result->documents['photo2']) }}">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group">
                    <label>Foto Evidance Survey 3</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="photo3" class="custom-file-input" id="exampleInputFilePhoto" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="exampleInputFilePhoto">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png</span>
                <div class="row">
                    @if ($survey->survey_result&&!empty($survey->survey_result->documents)&&isset($survey->survey_result->documents['photo3']))
                        <input type="hidden" name="photo_old3" value="{{ $survey->survey_result->documents['photo3'] }}">
                        <div class="col-lg-6 col-md-6 col-12">
                            <a href="{{ asset($survey->survey_result->documents['photo3']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($survey->survey_result->documents['photo3'])) }}">
                                <img class="img-fluid img-thumbnail" src="{{ view_asset($survey->survey_result->documents['photo3']) }}">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group">
                    <label>Foto Evidance Survey 4</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="photo4" class="custom-file-input" id="exampleInputFilePhoto" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="exampleInputFilePhoto">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png</span>
                <div class="row">
                    @if ($survey->survey_result&&!empty($survey->survey_result->documents)&&isset($survey->survey_result->documents['photo4']))
                        <input type="hidden" name="photo_old4" value="{{ $survey->survey_result->documents['photo4'] }}">
                        <div class="col-lg-6 col-md-6 col-12">
                            <a href="{{ asset($survey->survey_result->documents['photo4']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($survey->survey_result->documents['photo4'])) }}">
                                <img class="img-fluid img-thumbnail" src="{{ view_asset($survey->survey_result->documents['photo4']) }}">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group">
                    <label>Foto Evidance Survey 5</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="photo5" class="custom-file-input" id="exampleInputFilePhoto" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="exampleInputFilePhoto">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png</span>
                <div class="row">
                    @if ($survey->survey_result&&!empty($survey->survey_result->documents)&&isset($survey->survey_result->documents['photo5']))
                        <input type="hidden" name="photo_old5" value="{{ $survey->survey_result->documents['photo5'] }}">
                        <div class="col-lg-6 col-md-6 col-12">
                            <a href="{{ asset($survey->survey_result->documents['photo5']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($survey->survey_result->documents['photo5'])) }}">
                                <img class="img-fluid img-thumbnail" src="{{ view_asset($survey->survey_result->documents['photo5']) }}">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group">
                    <label>Foto Evidance Survey 6</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="photo6" class="custom-file-input" id="exampleInputFilePhoto" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="exampleInputFilePhoto">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png</span>
                <div class="row">
                    @if ($survey->survey_result&&!empty($survey->survey_result->documents)&&isset($survey->survey_result->documents['photo6']))
                        <input type="hidden" name="photo_old6" value="{{ $survey->survey_result->documents['photo6'] }}">
                        <div class="col-lg-6 col-md-6 col-12">
                            <a href="{{ asset($survey->survey_result->documents['photo6']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($survey->survey_result->documents['photo6'])) }}">
                                <img class="img-fluid img-thumbnail" src="{{ view_asset($survey->survey_result->documents['photo6']) }}">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group">
                    <label>Foto Evidance Survey 7</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="photo7" class="custom-file-input" id="exampleInputFilePhoto" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="exampleInputFilePhoto">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png</span>
                <div class="row">
                    @if ($survey->survey_result&&!empty($survey->survey_result->documents)&&isset($survey->survey_result->documents['photo7']))
                        <input type="hidden" name="photo_old7" value="{{ $survey->survey_result->documents['photo7'] }}">
                        <div class="col-lg-6 col-md-6 col-12">
                            <a href="{{ asset($survey->survey_result->documents['photo7']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($survey->survey_result->documents['photo7'])) }}">
                                <img class="img-fluid img-thumbnail" src="{{ view_asset($survey->survey_result->documents['photo7']) }}">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group">
                    <label>Foto Evidance Survey 8</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="photo8" class="custom-file-input" id="exampleInputFilePhoto" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="exampleInputFilePhoto">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png</span>
                <div class="row">
                    @if ($survey->survey_result&&!empty($survey->survey_result->documents)&&isset($survey->survey_result->documents['photo8']))
                        <input type="hidden" name="photo_old8" value="{{ $survey->survey_result->documents['photo8'] }}">
                        <div class="col-lg-6 col-md-6 col-12">
                            <a href="{{ asset($survey->survey_result->documents['photo8']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($survey->survey_result->documents['photo8'])) }}">
                                <img class="img-fluid img-thumbnail" src="{{ view_asset($survey->survey_result->documents['photo8']) }}">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group">
                    <label>Foto Evidance Survey 9</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="photo9" class="custom-file-input" id="exampleInputFilePhoto" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="exampleInputFilePhoto">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png</span>
                <div class="row">
                    @if ($survey->survey_result&&!empty($survey->survey_result->documents)&&isset($survey->survey_result->documents['photo9']))
                        <input type="hidden" name="photo_old9" value="{{ $survey->survey_result->documents['photo9'] }}">
                        <div class="col-lg-6 col-md-6 col-12">
                            <a href="{{ asset($survey->survey_result->documents['photo9']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($survey->survey_result->documents['photo9'])) }}">
                                <img class="img-fluid img-thumbnail" src="{{ view_asset($survey->survey_result->documents['photo9']) }}">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group">
                    <label>Foto Evidance Survey 10</label>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="photo10" class="custom-file-input" id="exampleInputFilePhoto" accept=".jpg,.jpeg,.png">
                        <label class="custom-file-label" for="exampleInputFilePhoto">Choose file</label>
                    </div>
                </div>
                <span class="text-info">Extensi: .jpg, .jpeg, .png</span>
                <div class="row">
                    @if ($survey->survey_result&&!empty($survey->survey_result->documents)&&isset($survey->survey_result->documents['photo10']))
                        <input type="hidden" name="photo_old10" value="{{ $survey->survey_result->documents['photo10'] }}">
                        <div class="col-lg-6 col-md-6 col-12">
                            <a href="{{ asset($survey->survey_result->documents['photo10']) }}" class="d-block mb-4 h-100 {{ bkpmumkm_colorbox(asset($survey->survey_result->documents['photo10'])) }}">
                                <img class="img-fluid img-thumbnail" src="{{ view_asset($survey->survey_result->documents['photo10']) }}">
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
