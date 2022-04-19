<div class="row">
    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="filter_periode_data">@lang('label.filter_periode')</label>
            <select id="filter_periode_data" class="form-control form-control-sm">
                @foreach(list_years() as $th)
                    <option value="{{ request()->fullUrlWithQuery(['periode' => $th]) }}" {{ ($th==$year?'selected':'') }}>{{ $th }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    @if(in_array($user->group_id, [GROUP_SUPER_ADMIN, GROUP_ADMIN, GROUP_QC_KOROP, GROUP_QC_KORWIL, GROUP_ASS_KORWIL, GROUP_TA]))
        <div class="col-12">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-success"><i class="fas fa-wallet"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text mb-2"><strong style="font-size: 20px;">@lang('label.ub_total_potensi_nilai_all')</strong></span>
                            <span class="info-box-number" style="font-size: 18px;">
                                Rp. <a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.survey.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.survey.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('verified'), 'periode' => $year, 'show_count' => true]) .'" data-method="GET" data-title="'. trans('label.ub_total_potensi_nilai_all') .'"' : '') !!}>{{ number_format($count_total_potensi_nilai_all,0,",",".") }}</a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-primary"><i class="fas">Rp</i></span>

                        <div class="info-box-content">
                            <span class="info-box-text mb-2"><strong style="font-size: 20px;">@lang('label.total_realisasi_nilai_kontrak')</strong></span>
                            <span class="info-box-number" style="font-size: 18px;">
                                Rp. <a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.kemitraan.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.kemitraan.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.total_realisasi_nilai_kontrak') .'"' : '') !!}>{{ number_format($count_total_realisasi_nilai_kontrak,0,",",".") }}</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="company-umkm-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="company-umkm-bar-tab" data-toggle="pill" href="#company-umkm-bar-content" role="tab" aria-controls="company-umkm-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="survey-umkm-pie-tab" data-toggle="pill" href="#company-umkm-pie-content" role="tab" aria-controls="company-umkm-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="company-umkm-tabContent">
                        <div class="tab-pane fade show active" id="company-umkm-bar-content" role="tabpanel" aria-labelledby="company-umkm-bar-tab">
                            <div id="company_umkm_bar"></div>
                        </div>
                        <div class="tab-pane fade" id="company-umkm-pie-content" role="tabpanel" aria-labelledby="company-umkm-pie-tab">
                            <div id="company_umkm_pie"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">
                            <th>{{ trans('label.index_company') }}</th>
                            <th>{{ trans('label.index_umkm_potensial') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.index_company') .'"' : '') !!}>{{ number_format($countUB,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.umkm.potensial.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.umkm.potensial.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.index_umkm_potensial') .'"' : '') !!}>{{ number_format($countUMKMPotensial,0,",",".") }}</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="kemitraan_ub_umkm-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="kemitraan_ub_umkm-bar-tab" data-toggle="pill" href="#kemitraan_ub_umkm-bar-content" role="tab" aria-controls="kemitraan_ub_umkm-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="kemitraan_ub_umkm-pie-tab" data-toggle="pill" href="#kemitraan_ub_umkm-pie-content" role="tab" aria-controls="kemitraan_ub_umkm-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="kemitraan_ub_umkm-tabContent">
                        <div class="tab-pane fade show active" id="kemitraan_ub_umkm-bar-content" role="tabpanel" aria-labelledby="kemitraan_ub_umkm-bar-tab">
                            <div id="kemitraan_ub_umkm_bar"></div>
                        </div>
                        <div class="tab-pane fade" id="kemitraan_ub_umkm-pie-content" role="tabpanel" aria-labelledby="kemitraan_ub_umkm-pie-tab">
                            <div id="kemitraan_ub_umkm_pie"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">
                            <th>{{ trans('label.kemitraan_ub') }}</th>
                            <th>{{ trans('label.kemitraan_umkm') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.kemitraan.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.kemitraan.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.kemitraan_ub') .'"' : '') !!}>{{ number_format($countKemitraanUB,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.kemitraan.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.kemitraan.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.kemitraan_umkm') .'"' : '') !!}>{{ number_format($countKemitraanUMKM,0,",",".") }}</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="grafik_ub-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="grafik_ub-bar-tab" data-toggle="pill" href="#grafik_ub-bar-content" role="tab" aria-controls="grafik_ub-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="grafik_ub-pie-tab" data-toggle="pill" href="#grafik_ub-pie-content" role="tab" aria-controls="grafik_ub-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="grafik_ub-tabContent">
                        <div class="tab-pane fade show active" id="grafik_ub-bar-content" role="tabpanel" aria-labelledby="grafik_ub-bar-tab">
                            <div id="grafik_ub_bar"></div>
                        </div>
                        <div class="tab-pane fade" id="grafik_ub-pie-content" role="tabpanel" aria-labelledby="grafik_ub-pie-tab">
                            <div id="grafik_ub_pie"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">                            
                            <th>{{ trans('label.company_status_bersedia') }}</th>
                            <th>{{ trans('label.company_status_tidak_bersedia') }}</th>
                            <th>{{ trans('label.company_status_tidak_respon') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.company_status_bersedia') .'"' : '') !!}>{{ number_format($count_ub_bersedia,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'tidak_bersedia', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.company_status_tidak_bersedia') .'"' : '') !!}>{{ number_format($count_ub_tidak_bersedia,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'tidak_respon', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.company_status_tidak_respon') .'"' : '') !!}>{{ number_format($count_ub_tidak_respon,0,",",".") }}</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="umkm_bersedia_menolak_tutup_pindah-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="umkm_bersedia_menolak_tutup_pindah-bar-tab" data-toggle="pill" href="#umkm_bersedia_menolak_tutup_pindah-bar-content" role="tab" aria-controls="umkm_bersedia_menolak_tutup_pindah-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="umkm_bersedia_menolak_tutup_pindah-pie-tab" data-toggle="pill" href="#umkm_bersedia_menolak_tutup_pindah-pie-content" role="tab" aria-controls="umkm_bersedia_menolak_tutup_pindah-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="umkm_bersedia_menolak_tutup_pindah-tabContent">
                        <div class="tab-pane fade show active" id="umkm_bersedia_menolak_tutup_pindah-bar-content" role="tabpanel" aria-labelledby="umkm_bersedia_menolak_tutup_pindah-bar-tab">
                            <div id="umkm_bersedia_menolak_tutup_pindah_bar"></div>
                        </div>
                        <div class="tab-pane fade" id="umkm_bersedia_menolak_tutup_pindah-pie-content" role="tabpanel" aria-labelledby="umkm_bersedia_menolak_tutup_pindah-pie-tab">
                            <div id="umkm_bersedia_menolak_tutup_pindah_pie"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">
                            <th>{{ trans('label.survey_umkm_status_bersedia') }}</th>
                            <th>{{ trans('label.survey_umkm_status_menolak') }}</th>
                            {{-- <th>{{ trans('label.survey_status_tutup') }}</th>
                            <th>{{ trans('label.survey_status_pindah') }}</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.umkm.potensial.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.umkm.potensial.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_umkm_status_bersedia') .'"' : '') !!}>{{ number_format($countUMKMBermitra,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.umkm.potensial.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.umkm.potensial.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_umkm_status_menolak') .'"' : '') !!}>{{ number_format($countUMKMBelumBermitra,0,",",".") }}</a></td>
                            {{-- <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.umkm.survey.bersedia.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.umkm.survey.bersedia.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_umkm_status_bersedia') .'"' : '') !!}>{{ number_format($countSurveyUMKMBersedia,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.survey.umkm.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.survey.umkm.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('menolak'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_umkm_status_menolak') .'"' : '') !!}>{{ number_format($countSurveyUMKMMenolak,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.survey.umkm.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.survey.umkm.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('tutup'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_status_tutup') .'"' : '') !!}>{{ number_format($countSurveyUMKMTutup,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.survey.umkm.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.survey.umkm.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('pindah'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_status_pindah') .'"' : '') !!}>{{ number_format($countSurveyUMKMPindah,0,",",".") }}</a></td> --}}
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="ub_by_wilayah-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="ub_by_wilayah-bar-tab" data-toggle="pill" href="#ub_by_wilayah-bar-content" role="tab" aria-controls="ub_by_wilayah-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ub_by_wilayah-pie-tab" data-toggle="pill" href="#ub_by_wilayah-pie-content" role="tab" aria-controls="ub_by_wilayah-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="ub_by_wilayah-tabContent">
                        <div class="tab-pane fade show active" id="ub_by_wilayah-bar-content" role="tabpanel" aria-labelledby="ub_by_wilayah-bar-tab">
                            <div id="ub_by_wilayah_bar"></div>
                        </div>
                        <div class="tab-pane fade" id="ub_by_wilayah-pie-content" role="tabpanel" aria-labelledby="ub_by_wilayah-pie-tab">
                            <div id="ub_by_wilayah_pie"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">
                            <th>{{ trans('label.wilayah_1') }}</th>
                            <th>{{ trans('label.wilayah_2') }}</th>
                            <th>{{ trans('label.wilayah_3') }}</th>
                            <th>{{ trans('label.wilayah_4') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '0', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_1') .'"' : '') !!}>{{ number_format($countUBWilayah1,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '1', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_2') .'"' : '') !!}>{{ number_format($countUBWilayah2,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '2', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_3') .'"' : '') !!}>{{ number_format($countUBWilayah3,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '3', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_4') .'"' : '') !!}>{{ number_format($countUBWilayah4,0,",",".") }}</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if(!in_array($user->group_id, [GROUP_SURVEYOR]))
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="umkm_has_or_not_nib-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="umkm_has_or_not_nib-bar-tab" data-toggle="pill" href="#umkm_has_or_not_nib-bar-content" role="tab" aria-controls="umkm_has_or_not_nib-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="umkm_has_or_not_nib-pie-tab" data-toggle="pill" href="#umkm_has_or_not_nib-pie-content" role="tab" aria-controls="umkm_has_or_not_nib-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="umkm_has_or_not_nib-tabContent">
                        <div class="tab-pane fade show active" id="umkm_has_or_not_nib-bar-content" role="tabpanel" aria-labelledby="umkm_has_or_not_nib-bar-tab">
                            <div id="umkm_has_or_not_nib_bar"></div>
                        </div>
                        <div class="tab-pane fade" id="umkm_has_or_not_nib-pie-content" role="tabpanel" aria-labelledby="umkm_has_or_not_nib-pie-tab">
                            <div id="umkm_has_or_not_nib_pie"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">
                            <th>{{ trans('label.umkm_has_nib') }}</th>
                            <th>{{ trans('label.umkm_not_nib') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.umkm.potensial.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.umkm.potensial.index", ['in-modal' => encrypt_decrypt('modal'), 'nib' => 'has', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.umkm_has_nib') .'"' : '') !!}>{{ number_format($countUMKMHasNIB,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.umkm.potensial.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.umkm.potensial.index", ['in-modal' => encrypt_decrypt('modal'), 'nib' => 'not', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.umkm_not_nib') .'"' : '') !!}>{{ number_format($countUMKMNotNIB,0,",",".") }}</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="ub_by_responed-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="ub_by_responed-bar-tab" data-toggle="pill" href="#ub_by_responed-bar-content" role="tab" aria-controls="ub_by_responed-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ub_by_responed-pie-tab" data-toggle="pill" href="#ub_by_responed-pie-content" role="tab" aria-controls="ub_by_responed-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="ub_by_responed-tabContent">
                        <div class="tab-pane fade show active" id="ub_by_responed-bar-content" role="tabpanel" aria-labelledby="ub_by_responed-bar-tab">
                            <div id="ub_by_responed_bar"></div>
                        </div>
                        <div class="tab-pane fade" id="ub_by_responed-pie-content" role="tabpanel" aria-labelledby="ub_by_responed-pie-tab">
                            <div id="ub_by_responed_pie"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">                        
                            <th>Total UB</th>                            
                            <th>Sudah Dihubungi</th>                               
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="ub_by_respon-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="ub_by_respon-bar-tab" data-toggle="pill" href="#ub_by_respon-bar-content" role="tab" aria-controls="ub_by_respon-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ub_by_respon-pie-tab" data-toggle="pill" href="#ub_by_respon-pie-content" role="tab" aria-controls="ub_by_respon-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="ub_by_respon-tabContent">
                        <div class="tab-pane fade show active" id="ub_by_respon-bar-content" role="tabpanel" aria-labelledby="ub_by_respon-bar-tab">
                            <div id="ub_by_respon_bar"></div>
                        </div>
                        <div class="tab-pane fade" id="ub_by_respon-pie-content" role="tabpanel" aria-labelledby="ub_by_respon-pie-tab">
                            <div id="ub_by_respon_pie"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">                          
                            <th>Respon</th>                            
                            <th>Tidak Respon</th>                            
                            <th>Tidak Aktif</th>                            
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="ub_by_meeting-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="ub_by_meeting-bar-tab" data-toggle="pill" href="#ub_by_meeting-bar-content" role="tab" aria-controls="ub_by_meeting-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ub_by_meeting-pie-tab" data-toggle="pill" href="#ub_by_meeting-pie-content" role="tab" aria-controls="ub_by_meeting-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="ub_by_meeting-tabContent">
                        <div class="tab-pane fade show active" id="ub_by_meeting-bar-content" role="tabpanel" aria-labelledby="ub_by_meeting-bar-tab">
                            <div id="ub_by_meeting_bar"></div>
                        </div>
                        <div class="tab-pane fade" id="ub_by_meeting-pie-content" role="tabpanel" aria-labelledby="ub_by_meeting-pie-tab">
                            <div id="ub_by_meeting_pie"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">                        
                            <th>Belum Terjadwal</th>                            
                            <th>Zoom</th>                            
                            <th>Offline</th>                            
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    {{-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div id="grafik_survey_ub_bar"></div>
                </div>
                <div class="card-footer p-0">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">
                            <th>{{ trans('label.survey_status_belum_survey') }}</th>
                            <th>{{ trans('label.survey_status_progress') }}</th>
                            <th>{{ trans('label.survey_status_done') }}</th>
                            <th>{{ trans('label.survey_status_verified') }}</th>
                            <th>{{ trans('label.survey_status_revision') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.survey.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.survey.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('belum_survey'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_status_belum_survey') .'"' : '') !!}>{{ number_format($countSurveyUB_belum_survey,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.survey.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.survey.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('progress'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_status_progress') .'"' : '') !!}>{{ number_format($countSurveyUB_progress,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.survey.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.survey.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('done'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_status_done') .'"' : '') !!}>{{ number_format($countSurveyUB_done,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.survey.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.survey.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('verified'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_status_verified') .'"' : '') !!}>{{ number_format($countSurveyUB_verified,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.survey.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.survey.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('revision'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_status_revision') .'"' : '') !!}>{{ number_format($countSurveyUB_revision,0,",",".") }}</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div id="survey_umkm_bar"></div>
            </div>
            <div class="card-footer p-0">
                <table class="table table-sm">
                    <thead>
                    <tr class="text-center">
                        @if(!in_array(auth()->user()->group_id, [GROUP_SURVEYOR]))
			                <th>{{ trans('label.umkm_potensial_belum_disurvey') }}</th>
                        @endif
                        <th>{{ trans('label.survey_status_progress') }}</th>
                        <th>{{ trans('label.survey_status_done') }}</th>
                        <th>{{ trans('label.survey_status_verified') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="text-center">
                        @if(!in_array(auth()->user()->group_id, [GROUP_SURVEYOR]))
			                <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.umkm.potensial.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.umkm.potensial.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('belum_disurvey'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.umkm_potensial_belum_disurvey') .'"' : '') !!}>{{ number_format($countUMKMPotensialBelumDisurvey,0,",",".") }}</a></td>
                        @endif
                        <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.survey.umkm.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.survey.umkm.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('progress'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_status_progress') .'"' : '') !!}>{{ number_format($countSurveyUMKMProgress,0,",",".") }}</a></td>
                        <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.survey.umkm.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.survey.umkm.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => encrypt_decrypt('done'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_status_done') .'"' : '') !!}>{{ number_format($countSurveyUMKMDone,0,",",".") }}</a></td>
                        <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.umkm.survey.verified.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.umkm.survey.verified.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.survey_status_verified') .'"' : '') !!}>{{ number_format($countSurveyUMKMVerified,0,",",".") }}</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

</div>
