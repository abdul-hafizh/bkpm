<style>
    h3.podcast {
        background-color: #0b56a4;
        font-size: 11pt;
        margin: 0;
        padding: 14px 14px 14px 20px;
        color: #fff;
        font-weight: 700;
    }

    .highcharts-color-1 {
        fill: #0b56a4 !important;
        stroke: #0b56a4 !important;
    }

    .highcharts-color-2 {
        fill: #28a745 !important;
        stroke: #28a745 !important;
    }

    .highcharts-color-3 {
        fill: #5d097c !important;
        stroke: #5d097c !important;
    }

    .ol-popup {
        position: absolute;
        background-color: white;
        /*--webkit-filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));*/
        filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #cccccc;
        bottom: 12px;
        left: -50px;
        min-width: 480px;
    }

    .ol-popup:after, .ol-popup:before {
        top: 100%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
    }

    .ol-popup:after {
        border-top-color: white;
        border-width: 10px;
        left: 48px;
        margin-left: -10px;
    }

    .ol-popup:before {
        border-top-color: #cccccc;
        border-width: 11px;
        left: 48px;
        margin-left: -11px;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-2 col-md-2 col-12 form-group">
                <label for="filter_periode_data">@lang('label.filter_periode')</label>
                <select id="filter_periode_data" class="form-control form-control-sm">
                    @foreach(list_years() as $th)
                        <option value="{{ request()->fullUrlWithQuery(['periode' => $th]) }}" {{ ($th==$year?'selected':'') }}>{{ $th }}</option>
                    @endforeach
                </select>
            </div>               
            <div class="col-sm-2 col-md-2 col-12 form-group">
                <label>@lang('label.wilayah')</label>
                <select id="filter_wilayah_data" class="form-control form-control-sm">
                    @foreach(list_bkpmumkm_wilayah_by_user() as $wilayah_filter)
                        <option value="{{ request()->fullUrlWithQuery(['wilayah_id' => $wilayah_filter['id']]) }}" data-provinces=\'@json($wilayah_filter['provinces'])\' {{ ('wil'.$wilayah_filter['id']=='wil'.$wilayah_id?'selected':'') }}>{{ $wilayah_filter['name'] }}</option>
                    @endforeach
                </select>
            </div>               
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
            <div class="mb-2">
                <h3 class="podcast"><i class="fas fa-tags mr-2"></i> {{ trans('label.index_company') }} & {{ trans('label.index_umkm') }}</h3>
            </div>
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
        @if($wilayah_id == 'all')
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="mb-2">
                    <h3 class="podcast"><i class="fas fa-tags mr-2"></i> PMA/PMDN Yang Potensi Kontrak</h3>
                </div>
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
                                <th>Wilayah 5</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-center">
                                <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '0', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_1') .'"' : '') !!}>{{ number_format($countUBWilayah1,0,",",".") }}</a></td>
                                <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '1', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_2') .'"' : '') !!}>{{ number_format($countUBWilayah2,0,",",".") }}</a></td>
                                <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '2', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_3') .'"' : '') !!}>{{ number_format($countUBWilayah3,0,",",".") }}</a></td>
                                <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '3', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_4') .'"' : '') !!}>{{ number_format($countUBWilayah4,0,",",".") }}</a></td>
                                <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '4', 'periode' => $year]) .'" data-method="GET" data-title="Wilayah 5"' : '') !!}>{{ number_format($countUBWilayah5,0,",",".") }}</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @elseif($wilayah_id == 0)
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="mb-2">
                    <h3 class="podcast"><i class="fas fa-tags mr-2"></i> PMA/PMDN Yang Potensi Kontrak</h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="ub_by_wilayah1-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="ub_by_wilayah1-bar-tab" data-toggle="pill" href="#ub_by_wilayah1-bar-content" role="tab" aria-controls="ub_by_wilayah1-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ub_by_wilayah1-pie-tab" data-toggle="pill" href="#ub_by_wilayah1-pie-content" role="tab" aria-controls="ub_by_wilayah1-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="ub_by_wilayah1-tabContent">
                            <div class="tab-pane fade show active" id="ub_by_wilayah1-bar-content" role="tabpanel" aria-labelledby="ub_by_wilayah1-bar-tab">
                                <div id="ub_by_wilayah1_bar"></div>
                            </div>
                            <div class="tab-pane fade" id="ub_by_wilayah1-pie-content" role="tabpanel" aria-labelledby="ub_by_wilayah1-pie-tab">
                                <div id="ub_by_wilayah1_pie"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <table class="table table-sm">
                            <thead>
                            <tr class="text-center">
                                <th>{{ trans('label.wilayah_1') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-center">
                                <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '0', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_1') .'"' : '') !!}>{{ number_format($countUBWilayah1,0,",",".") }}</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @elseif($wilayah_id == 1)
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="mb-2">
                    <h3 class="podcast"><i class="fas fa-tags mr-2"></i> PMA/PMDN Yang Potensi Kontrak</h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="ub_by_wilayah2-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="ub_by_wilayah2-bar-tab" data-toggle="pill" href="#ub_by_wilayah2-bar-content" role="tab" aria-controls="ub_by_wilayah2-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ub_by_wilayah2-pie-tab" data-toggle="pill" href="#ub_by_wilayah2-pie-content" role="tab" aria-controls="ub_by_wilayah2-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="ub_by_wilayah2-tabContent">
                            <div class="tab-pane fade show active" id="ub_by_wilayah2-bar-content" role="tabpanel" aria-labelledby="ub_by_wilayah2-bar-tab">
                                <div id="ub_by_wilayah2_bar"></div>
                            </div>
                            <div class="tab-pane fade" id="ub_by_wilayah2-pie-content" role="tabpanel" aria-labelledby="ub_by_wilayah2-pie-tab">
                                <div id="ub_by_wilayah2_pie"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <table class="table table-sm">
                            <thead>
                            <tr class="text-center">
                                <th>{{ trans('label.wilayah_2') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-center">
                                <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '1', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_2') .'"' : '') !!}>{{ number_format($countUBWilayah2,0,",",".") }}</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @elseif($wilayah_id == 2)
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="mb-2">
                    <h3 class="podcast"><i class="fas fa-tags mr-2"></i> PMA/PMDN Yang Potensi Kontrak</h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="ub_by_wilayah3-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="ub_by_wilayah3-bar-tab" data-toggle="pill" href="#ub_by_wilayah3-bar-content" role="tab" aria-controls="ub_by_wilayah3-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ub_by_wilayah3-pie-tab" data-toggle="pill" href="#ub_by_wilayah3-pie-content" role="tab" aria-controls="ub_by_wilayah3-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="ub_by_wilayah3-tabContent">
                            <div class="tab-pane fade show active" id="ub_by_wilayah3-bar-content" role="tabpanel" aria-labelledby="ub_by_wilayah3-bar-tab">
                                <div id="ub_by_wilayah3_bar"></div>
                            </div>
                            <div class="tab-pane fade" id="ub_by_wilayah3-pie-content" role="tabpanel" aria-labelledby="ub_by_wilayah3-pie-tab">
                                <div id="ub_by_wilayah3_pie"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <table class="table table-sm">
                            <thead>
                            <tr class="text-center">
                                <th>{{ trans('label.wilayah_3') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-center">
                                <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '2', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_3') .'"' : '') !!}>{{ number_format($countUBWilayah3,0,",",".") }}</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @elseif($wilayah_id == 3)
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="mb-2">
                    <h3 class="podcast"><i class="fas fa-tags mr-2"></i> PMA/PMDN Yang Potensi Kontrak</h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="ub_by_wilayah4-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="ub_by_wilayah4-bar-tab" data-toggle="pill" href="#ub_by_wilayah4-bar-content" role="tab" aria-controls="ub_by_wilayah4-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ub_by_wilayah4-pie-tab" data-toggle="pill" href="#ub_by_wilayah4-pie-content" role="tab" aria-controls="ub_by_wilayah4-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="ub_by_wilayah4-tabContent">
                            <div class="tab-pane fade show active" id="ub_by_wilayah4-bar-content" role="tabpanel" aria-labelledby="ub_by_wilayah4-bar-tab">
                                <div id="ub_by_wilayah4_bar"></div>
                            </div>
                            <div class="tab-pane fade" id="ub_by_wilayah4-pie-content" role="tabpanel" aria-labelledby="ub_by_wilayah-pie-tab">
                                <div id="ub_by_wilayah4_pie"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <table class="table table-sm">
                            <thead>
                            <tr class="text-center">
                                <th>{{ trans('label.wilayah_4') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-center">
                                <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '3', 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.wilayah_4') .'"' : '') !!}>{{ number_format($countUBWilayah4,0,",",".") }}</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @elseif($wilayah_id == 4)
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="mb-2">
                    <h3 class="podcast"><i class="fas fa-tags mr-2"></i> PMA/PMDN Yang Potensi Kontrak</h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="ub_by_wilayah5-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="ub_by_wilayah5-bar-tab" data-toggle="pill" href="#ub_by_wilayah5-bar-content" role="tab" aria-controls="ub_by_wilayah5-bar-content" aria-selected="true"><i class="fas fa-chart-bar"></i> Bar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ub_by_wilayah5-pie-tab" data-toggle="pill" href="#ub_by_wilayah5-pie-content" role="tab" aria-controls="ub_by_wilayah5-pie-content" aria-selected="true"><i class="fas fa-chart-pie"></i> Pie</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="ub_by_wilayah5-tabContent">
                            <div class="tab-pane fade show active" id="ub_by_wilayah5-bar-content" role="tabpanel" aria-labelledby="ub_by_wilayah5-bar-tab">
                                <div id="ub_by_wilayah5_bar"></div>
                            </div>
                            <div class="tab-pane fade" id="ub_by_wilayah5-pie-content" role="tabpanel" aria-labelledby="ub_by_wilayah-pie-tab">
                                <div id="ub_by_wilayah5_pie"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <table class="table table-sm">
                            <thead>
                            <tr class="text-center">                                
                                <th>Wilayah 5</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-center">
                                <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'status' => 'bersedia', 'wilayah_id' => '4', 'periode' => $year]) .'" data-method="GET" data-title="Wilayah 5"' : '') !!}>{{ number_format($countUBWilayah5,0,",",".") }}</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-lg-6 col-sm-12 col-xs-12">
            <div class="mb-2">
                <h3 class="podcast"><i class="fas fa-tags mr-2"></i> Perusahaan Yang Sudah Dihubungi</h3>
            </div>
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
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'periode' => $year]) .'" data-method="GET" data-title="'. trans('label.index_company') .'"' : '') !!}>{{ number_format($countUB,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'flag_respon' => 'respon', 'periode' => $year]) .'" data-method="GET" data-title="Sudah Dihubungi"' : '') !!}>{{ number_format($countResponed,0,",",".") }}</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="mb-2">
                <h3 class="podcast"><i class="fas fa-tags mr-2"></i> Perusahaan Berdasarkan Respon</h3>
            </div>
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
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'flag_respon' => 'respon1', 'periode' => $year]) .'" data-method="GET" data-title="Perusahaan Yang Merespon"' : '') !!}>{{ number_format($countRespon,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'flag_respon' => 'respon2', 'periode' => $year]) .'" data-method="GET" data-title="Perusahaan Tidak Merespon"' : '') !!}>{{ number_format($countTdkRespon,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'flag_respon' => 'respon3', 'periode' => $year]) .'" data-method="GET" data-title="Perusahaan TIdak Aktif"' : '') !!}>{{ number_format($countTdkAktif,0,",",".") }}</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="mb-2">
                <h3 class="podcast"><i class="fas fa-tags mr-2"></i> Perusahaan Berdasarkan Kelanjutan Komunikasi</h3>
            </div>
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
                            <th>Online Meeting</th>                            
                            <th>Offline Meeting</th>                            
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'flag_zoom' => 'blmJadwal', 'periode' => $year]) .'" data-method="GET" data-title="Belum Terjadwal"' : '') !!}>{{ number_format($countBlmJadwal,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'flag_zoom' => 'online', 'periode' => $year]) .'" data-method="GET" data-title="Online Meeting"' : '') !!}>{{ number_format($countZoom,0,",",".") }}</a></td>
                            <td><a href="javascript:void(0);" {!! (hasRoutePermission("{$identifier}.backend.company.index") ? 'class="show_modal_ex_lg" data-action="'. route("{$identifier}.backend.company.index", ['in-modal' => encrypt_decrypt('modal'), 'flag_zoom' => 'offline', 'periode' => $year]) .'" data-method="GET" data-title="Offline Meeting"' : '') !!}>{{ number_format($countOffline,0,",",".") }}</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="mb-2">
                <h3 class="podcast"><i class="fas fa-tags mr-2"></i> @lang('label.grafik_ub')</h3>
            </div>
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
    @endif
    @if(!in_array($user->group_id, [GROUP_SURVEYOR]))
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="mb-2">
                <h3 class="podcast"><i class="fas fa-tags mr-2"></i> @lang('label.umkm_has_or_not_nib')</h3>
            </div>
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
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="mb-2">
                <h3 class="podcast"><i class="fas fa-tags mr-2"></i> @lang('label.kemitraan_ub_umkm')</h3>
            </div>
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
    @endif
    {{-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="mb-2">
                <h3 class="podcast"><i class="fas fa-tags mr-2"></i> @lang('label.grafik_survey_ub')</h3>
            </div>
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
        <div class="mb-2">
            <h3 class="podcast"><i class="fas fa-tags mr-2"></i> {{ trans('label.survey_umkm') }}</h3>
        </div>
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

    <div class="col-sm-12 col-xs-12">
        <div class="mb-2">
            <h3 class="podcast"><i class="fas fa-tags mr-2"></i> Sebaran Usaha Besar Bermitra</h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="box-body">
                    <div id="map_ub" style="width:auto; height:450px"></div>
                    <div id="popup_ub" class="ol-popup">
                        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                        <div id="popup-contentUb"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-xs-12">
        <div class="mb-2">
            <h3 class="podcast"><i class="fas fa-tags mr-2"></i> Sebaran UMKM Bermitra</h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="box-body">
                    <div id="map" style="width:auto; height:450px"></div>
                    <div id="popup" class="ol-popup">
                        <a href="#" id="popup-closerUb" class="ol-popup-closer"></a>
                        <div id="popup-content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>

<script>
    // map start

        var data_lokasi = @json($lokasi);
        var data_lokasi_ub = @json($lokasi_ub);
        var ALLL = ol.proj.fromLonLat([118.0148634,-2.548926 ]);
        var DWI = ol.proj.fromLonLat([98.678513,3.597031]);
        var DWII = ol.proj.fromLonLat([111.257832302, -7.50166466]);
        var DWIII = ol.proj.fromLonLat([114.44753857758242,  1.4197101910832077]);
        var DWIV = ol.proj.fromLonLat([120.57077305954977, -1.5781610328357976]);

        var view = new ol.View({
            center: ALLL,
            zoom: 5.2
        });

        var view2 = new ol.View({
            center: ALLL,
            zoom: 5.2
        });

        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                source: new ol.source.OSM()
            })
            ],

            loadTilesWhileAnimating: true,
            view: view
        });

        var map_ub = new ol.Map({
            target: 'map_ub',
            layers: [
                new ol.layer.Tile({
                source: new ol.source.OSM()
            })
            ],

            loadTilesWhileAnimating: true,
            view: view2
        });

        var vectorSource = new ol.source.Vector({});
        var vectorSourceUb = new ol.source.Vector({});
        var features = [];

        for (let i = 0; i < data_lokasi.length; i++) {
            var pict;
            var area  = data_lokasi[i][6];

            switch(area) {
            case 'DW1':
                pict = "https://eri.progressreport.net/assets/img/map-coklat.png";
                break;
            case 'DW2':
                pict = "https://eri.progressreport.net/assets/img/map-biru.png";
                break;
            case 'DW3':
                pict = "https://eri.progressreport.net/assets/img/map-hijautua.png";
                break;
            case 'DW4':
                pict = "https://eri.progressreport.net/assets/img/map-ungu.png";
                break;        
            default:
                pict = "https://eri.progressreport.net/assets/img/map-biru.png";
            }

            var iconFeature = new ol.Feature({        
                geometry: new ol.geom.Point(ol.proj.transform([data_lokasi[i][7],data_lokasi[i][8]],  'EPSG:4326', 'EPSG:3857')),
                id : data_lokasi[i][0],
                name : 'peta',
                description : '<table width="480" border="0" cellspacing="0" cellpadding="0"><tr valign="top"><td width="166">Nama UMKM</td><td width="5">:</td><td width="295"><a href="https://kemitraan.fasilitasi.id/id/backend/bkpm-umkm/perusahaan">'+data_lokasi[i][1]+'</a></td></tr><tr valign="top"><td>Alamat</td><td>:</td><td>'+data_lokasi[i][2]+'</td></tr><tr valign="top"><td>Nama Provinsi</td><td>:</td><td>'+data_lokasi[i][3]+'</td></tr><tr valign="top"><td>Nama Kabupaten</td><td>:</td><td>'+data_lokasi[i][4]+'</td></tr></table>',
            });

            var iconStyle = new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 0.5],
                    anchorXUnits: "fraction",
                    anchorYUnits: "fraction",
                    src: pict
                    })
                });
            iconFeature.setStyle(iconStyle);
            vectorSource.addFeature(iconFeature);
        }

        for (let i = 0; i < data_lokasi_ub.length; i++) {
            var pict_ub;
            var area_ub  = data_lokasi_ub[i][6];

            switch(area_ub) {
            case 'DW1':
                pict_ub = "https://eri.progressreport.net/assets/img/map-coklat.png";
                break;
            case 'DW2':
                pict_ub = "https://eri.progressreport.net/assets/img/map-biru.png";
                break;
            case 'DW3':
                pict_ub = "https://eri.progressreport.net/assets/img/map-hijautua.png";
                break;
            case 'DW4':
                pict_ub = "https://eri.progressreport.net/assets/img/map-ungu.png";
                break;        
            default:
                pict_ub = "https://eri.progressreport.net/assets/img/map-biru.png";
            }

            var iconFeatureUb = new ol.Feature({        
                geometry: new ol.geom.Point(ol.proj.transform([data_lokasi_ub[i][7],data_lokasi_ub[i][8]],  'EPSG:4326', 'EPSG:3857')),
                id : data_lokasi_ub[i][0],
                name : 'peta_ub',
                description : '<table width="480" border="0" cellspacing="0" cellpadding="0"><tr valign="top"><td width="166">Nama UMKM</td><td width="5">:</td><td width="295"><a href="https://kemitraan.fasilitasi.id/id/backend/bkpm-umkm/perusahaan">'+data_lokasi_ub[i][1]+'</a></td></tr><tr valign="top"><td>Alamat</td><td>:</td><td>'+data_lokasi_ub[i][2]+'</td></tr><tr valign="top"><td>Nama Provinsi</td><td>:</td><td>'+data_lokasi_ub[i][3]+'</td></tr><tr valign="top"><td>Nama Kabupaten</td><td>:</td><td>'+data_lokasi_ub[i][4]+'</td></tr></table>',
            });

            var iconStyleUb = new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 0.5],
                    anchorXUnits: "fraction",
                    anchorYUnits: "fraction",
                    src: pict_ub
                    })
                });
            iconFeatureUb.setStyle(iconStyleUb);
            vectorSourceUb.addFeature(iconFeatureUb);
        }

        var vectorLayer = new ol.layer.Vector({
            source: vectorSource,
            updateWhileAnimating: true,
            updateWhileInteracting: true
        });

        var vectorLayerUb = new ol.layer.Vector({
            source: vectorSourceUb,
            updateWhileAnimating: true,
            updateWhileInteracting: true
        });

        map.addLayer(vectorLayer); 
        map_ub.addLayer(vectorLayerUb); 

    // map end

    // initialize the popup
  
        var container = document.getElementById('popup');
        var container2 = document.getElementById('popup_ub');
        var content = document.getElementById('popup-content');
        var content2 = document.getElementById('popup-contentUb');
        var closer = document.getElementById('popup-closer');
        var closer2 = document.getElementById('popup-closerUb');

        var overlay = new ol.Overlay({
            element: container,
            autoPan: true,
            autoPanAnimation: {
                duration: 250
            }
        });

        var overlay2 = new ol.Overlay({
            element: container2,
            autoPan: true,
            autoPanAnimation: {
                duration: 250
            }
        });

        map.addOverlay(overlay);
        map_ub.addOverlay(overlay2);

        closer.onclick = function() {
            overlay.setPosition(undefined);
            closer.blur();
            return false;
        };

        closer2.onclick = function() {
            overlay2.setPosition(undefined);
            closer2.blur();
            return false;
        };

        map.on('click', function (event) {
            var feature = map.forEachFeatureAtPixel(event.pixel, 
            function(feature) {
                return feature;
            });  
            if (feature) {
                var coordinate = feature.getGeometry().getCoordinates();
                content.innerHTML =feature.get('description')
                overlay.setPosition(coordinate);
            } else {
                overlay.setPosition(undefined);
                closer.blur();
            }
        });

        map_ub.on('click', function (event) {
            var feature2 = map_ub.forEachFeatureAtPixel(event.pixel, 
            function(feature2) {
                return feature2;
            });  
            if (feature2) {
                var coordinate2 = feature2.getGeometry().getCoordinates();
                content2.innerHTML =feature2.get('description')
                overlay2.setPosition(coordinate2);
            } else {
                overlay2.setPosition(undefined);
                closer2.blur();
            }
        });

    // initialize the popup end

    function flyTo(location, done) {
        var duration = 2000;
        var zoom = view.getZoom();
        var parts = 2;
        var called = false;
        function callback(complete) {
            --parts;
            if (called) {
            return;
            }
            if (parts === 0 || !complete) {
            called = true;
            done(complete);
            }
        }
        view.animate({
            center: location,
            duration: duration
        }, callback);
        view.animate({
            zoom: zoom - 1,
            duration: duration / 2
        }, {
            zoom: zoom,
            duration: duration / 2
        }, callback);
    }

    function onClick(id, callback) {
        document.getElementById(id).addEventListener('click', callback);
    }

    onClick('TO-ALLL', function() {
        flyTo(ALLL, function() {});
    });

    onClick('TO-DWI', function() {
        flyTo(DWI, function() {});
    });

    onClick('TO-DWII', function() {
        flyTo(DWII, function() {});
    });

    onClick('TO-DWIII', function() {
        flyTo(DWIII, function() {});
    });

    onClick('TO-DWIV', function() {
        flyTo(DWIV, function() {});
    });

</script>