{!! library_leaflet('css') !!}
<div class="modal-body">
    <div class="row mb-3">
        <div class="col-12">
            <a href="javascript:void(0);" {!! 'class="show_modal_ex_lg btn btn-warning btn-sm" data-action="'. route("simple_cms.plugins.bkpmumkm.backend.kemitraan.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => '2020']) .'" data-method="GET" data-title="'. trans('label.total_realisasi_nilai_kontrak') .'"' !!}><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-company-detail-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-profileCompanyDetail-tab" data-toggle="pill" href="#custom-tabs-profileCompanyDetail" role="tab" aria-controls="custom-tabs-profileCompanyDetail" aria-selected="true">@lang('label.profile_ub_umkm')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-surveyCompanyDetail-tab" data-toggle="pill" href="#custom-tabs-surveyCompanyDetail" role="tab" aria-controls="custom-tabs-surveyCompanyDetail" aria-selected="false">@lang('label.result_survey_ub_umkm')</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-company-detail-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-profileCompanyDetail" role="tabpanel" aria-labelledby="custom-tabs-profileCompanyDetail-tab">
                            @switch($category_company)
                                @case(CATEGORY_COMPANY)
                                    @include("{$bkpmumkm_identifier}::company.sections.detail", ['company' => $survey->{$category_company}, 'auth_check' => auth()->check()])
                                @break
                                @case(CATEGORY_UMKM)
                                    @include("{$bkpmumkm_identifier}::umkm.sections.potensial.detail", ['umkm' => $survey->{$category_company}, 'auth_check' => auth()->check()])
                                @break
                            @endswitch
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-surveyCompanyDetail" role="tabpanel" aria-labelledby="custom-tabs-surveyCompanyDetail-tab">
                            @switch($category_company)
                                @case(CATEGORY_COMPANY)
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-center">FORMULIR SURVEI KELOMPOK USAHA BESAR (UB)</h3>
                                    </div>
                                </div>

                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_profil_usaha")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_kebutuhan_kemitraan")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_kemitraan_sedang_berjalan")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_standar_kriteria_persyaratan")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_responden")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.note_revision")
                                @break
                                @case(CATEGORY_UMKM)
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-center">FORMULIR SURVEI KELOMPOK USAHA MENENGAH KECIL MIKRO (UMKM)</h3>
                                        <h3 class="text-center">MENDORONG INVESTASI BESAR BERMITRA DENGAN UMKM TAHUN {{ ($survey ? \Carbon\Carbon::parse($survey->created_at)->format('Y') : \Carbon\Carbon::now()->format('Y')) }}</h3>
                                    </div>
                                </div>

                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_profil_usaha")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_kemampuan_finansial")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_profil_produk_barang_jasa")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_profil_pengelolaan_usaha")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_pengalaman_ekspor")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_fasilitas_usaha")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_pengalaman_kerja_sama_kemitraan")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_hal_lain")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.details.detail_responden")
                                @include("{$bkpmumkm_identifier}::survey.backend.partials.note_revision")
                                @break
                            @endswitch

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">

                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="status_survey">Status</label>
                                                <br/>
                                                {{ trans("label.survey_status_{$survey->status}") }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">@lang('label.close')</button>
</div>
{!! library_leaflet('js', true) !!}
<script>
    $(document).ready(function(){
        $(document).on('click', 'input[type="radio"], input[type="checkbox"]', function(e){
            e.preventDefault();
            return false;
        });
    });
</script>
