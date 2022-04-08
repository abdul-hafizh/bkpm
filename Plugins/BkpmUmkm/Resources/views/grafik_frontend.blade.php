<div class="row mb-n7">
    <div class="col-xl-6 col-lg-6 mb-7">
        <div class="title-section">
            <span class="sub-title">@lang('label.chart')</span>
            <h3 class="title">
                @lang('label.home_chart_left')
            </h3>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label id="periodeGrafik">@lang('label.periode')</label>
                            <select id="periodeGrafik" name="periode_grafik" class="form-control form-control-sm">
                                @foreach($periodes as $periode)
                                    <option value="{{ $periode }}">{{ $periode }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div id="chartUbUmkm" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 order-first order-lg-last col-lg-6 mb-7 ">
        <div class="title-section">
            <span class="sub-title">@lang('label.chart')</span>
            <h3 class="title">
                @lang('label.home_chart_right')
            </h3>
            <div class="row">
                <div class="col-12">&nbsp;</div>
                <div class="col-12">
                    <div id="chartSurveyUmkmBersediaMenolak" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
