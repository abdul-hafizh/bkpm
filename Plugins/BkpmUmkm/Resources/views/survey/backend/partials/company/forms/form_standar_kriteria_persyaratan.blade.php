<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">4. Standar dan Kriteria UMKM yang Disyaratkan UB</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @php
                $standar_kriteria_persyaratan    = ($survey->survey_result->data && (isset($survey->survey_result->data['standar_kriteria_persyaratan'])&&$survey->survey_result->data['standar_kriteria_persyaratan']) ? $survey->survey_result->data['standar_kriteria_persyaratan'] : '');
            @endphp
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <textarea name="data[standar_kriteria_persyaratan]" placeholder="Standar dan Kriteria UMKM yang Disyaratkan UB" class="form-control form-control-sm editor">{!! shortcodes($standar_kriteria_persyaratan) !!}</textarea>
            </div>
        </div>
    </div>
</div>
