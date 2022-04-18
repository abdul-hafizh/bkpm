<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">8. Hal-hal lain yang perlu disampaikan kepada calon mitra Usaha Besar:</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @php
                $hal_lain    = ($survey->survey_result->data && (isset($survey->survey_result->data['hal_lain'])&&$survey->survey_result->data['hal_lain']) ? $survey->survey_result->data['hal_lain'] : '');
            @endphp
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <textarea name="data[hal_lain]" placeholder="Hal-hal lain yang perlu disampaikan kepada calon mitra Usaha Besar" class="form-control form-control-sm editor">{!! shortcodes($hal_lain) !!}</textarea>
            </div>
        </div>
    </div>
</div>
