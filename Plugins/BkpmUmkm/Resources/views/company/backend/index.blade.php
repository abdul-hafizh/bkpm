@extends('core::layouts.backend')
@section('title', $title)
@section('breadcrumb')
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! library_datatables('css') !!}
@endpush
@section('layout')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body pad">
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
            {!! form_import_single("{$bkpmumkm_identifier}.backend.company.import", plugins_asset('bkpmumkm', 'company/files/format-import-usaha-besar.xlsx'), '', true) !!}
        </div>
    </div>
@endsection

@push('js_stack')
    <script>
         $(document).ready(function () {
            let dataTables_wrapper= $('div.dataTables_wrapper').find('div.row');
            dataTables_wrapper.find('div.toolbar-button-datatable').removeClass('col-md-6').addClass('col-md-8');
            dataTables_wrapper.find('div.text-right').removeClass('col-md-6').addClass('col-md-4');

        });

        $(document).ready(function () {

            $(document).on('submit', 'form#formDownloadBeritaAcara', function (e) {
                e.preventDefault();
                let self = $(this),
                    url = self.attr('data-action'),
                    params = self.serializeJSON();
                $.ajax({
                    url: url, type: 'GET', typeData: 'json', cache: false, data: params,
                    success: function (data) {
                        window.location.href = data.body.redirect
                        simple_cms.modalDismiss();
                    }
                });
            });

            $(document).on('click', '.eventSurveyChangeStatus', function (e) {
                let self = $(this),
                    url = self.attr('data-action'),
                    params = {},
                    dataTableID = self.attr('data-selecteddatatable'),
                    title = self.html();
                Swal.fire({
                    title: 'Change status.?',
                    html: 'Change status to <strong>'+title+'</strong>',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#fa0202",
                    confirmButtonText: 'Change.!',
                    reverseButtons: true,
                    preConfirm: () => {
                        return $.ajax({
                            url:url, type:'POST', typeData:'json',  cache:false, data:params,
                            success: function(data){
                                if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableID] !== "undefined"){
                                    (window.LaravelDataTables[dataTableID]).draw();
                                }
                                return data;
                            }
                        });
                    },
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.value) {
                        simple_cms.responseMessageWithSwal(result.value);
                    }
                });
            });

            $(document).on('submit', 'form#formChangeStatusRevision', function (e) {
                e.preventDefault();
                let self = $(this),
                    url = self.attr('data-action'),
                    params = self.serializeJSON(),
                    dataTableID = $(document).find('table.dataTable').attr('id'),
                    title = $('input#title_confirm').val();
                Swal.fire({
                    title: title +'?',
                    html: '',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#fa0202",
                    confirmButtonText: 'Change.!',
                    reverseButtons: true,
                    preConfirm: () => {
                        return $.ajax({
                            url:url, type:'POST', typeData:'json',  cache:false, data:params,
                            success: function(data){
                                if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableID] !== "undefined"){
                                    (window.LaravelDataTables[dataTableID]).draw();
                                }
                                return data;
                            }
                        });
                    },
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.value) {
                        simple_cms.responseMessageWithSwal(result.value);
                    }
                });
            });

            $(document).on('submit', 'form#formInputScoringSurvey', function (e) {
                e.preventDefault();
                let self = $(this),
                    url = self.attr('data-action'),
                    params = self.serialize(),
                    dataTableID = $(document).find('table.dataTable').attr('id');
                $.ajax({
                    url:url, type:'POST', typeData:'json',  cache:false, data:params,
                    success: function(data){
                        if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableID] !== "undefined"){
                            (window.LaravelDataTables[dataTableID]).draw();
                        }
                        simple_cms.modalDismiss();
                        return simple_cms.ToastSuccess(data);
                    }
                });
            });

            let dataTableID = $(document).find('table.dataTable').attr('id'),
            periode = '<div class="form-group col-2">';
            periode += '<label>Periode</label>';
            periode += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm" name="periode">';
            $.each(periodes, function(idx, val){
                periode += '<option value="'+ val +'">'+ val +'</option>';
            });
            periode += '</select>';
            periode += '</div>';

            $(`form#${dataTableID}Form`).append(periode+filter_wilayah_status);

            $(document).on('change', 'select.filterDataTableWilayah', function(){
                let self = $(this),
                    selectProvinsiOption = '<option value="all" selected>'+label_all_provinsi +'</option>',
                    provinces = $('select.filterDataTableWilayah > option:selected', document).attr('data-provinces');
                provinces = (typeof provinces === "string" ? JSON.parse(provinces):provinces);

                if ($('select.select2FilterDataTableProvinsi',document).length && self.val()==='all'){
                    let reMapProvincesAll = [];
                    $.each($('select.filterDataTableWilayah > option', document), function(){
                        let getProv = $(this).attr('data-provinces');
                        getProv = (typeof getProv === "string" ? JSON.parse(getProv):getProv);
                        $.merge(reMapProvincesAll, getProv);
                    });
                    provinces = reMapProvincesAll;
                }

                if (provinces.length) {
                    $.each(provinces, function(idx, val){
                        selectProvinsiOption += `<option value="${val.kode_provinsi}">${val.nama_provinsi}</option>`;
                    });
                }
                $('select.filterDataTableProvinsi', document).html(selectProvinsiOption);
            });

            $('select[name="status_survey"]').trigger('change');

            $('.select2FilterDataTableProvinsi',document).select2({
                placeholder: "--Select--",
                allowClear: true,
                theme: 'bootstrap4',
                width: '100%',
                multiple:true,
                tags: true
            });
        });

        @php
            $periodes = [];
            foreach (list_years() as $y) {
                $periodes[] = $y;
            }
        @endphp
        
        const periodes = @json($periodes),        
        label_all_provinsi = '@lang('label.all_provinsi')';
        let filter_wilayah_status = '';

        @if(in_array(auth()->user()->group_id, [GROUP_QC_KORWIL,GROUP_ASS_KORWIL,GROUP_TA,GROUP_SUPER_ADMIN,GROUP_ADMIN]))
            filter_wilayah_status += '<div class="col-2 form-group">';
            filter_wilayah_status += '<label>@lang('label.wilayah')</label>';
            filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableWilayah" name="wilayah_id">';
            @foreach(list_bkpmumkm_wilayah_by_user() as $wilayah_filter)
                filter_wilayah_status += '<option value="{{ $wilayah_filter['id'] }}" data-provinces=\'@json($wilayah_filter['provinces'])\'>{{ $wilayah_filter['name'] }}</option>';
            @endforeach
            filter_wilayah_status += '</select>';
            filter_wilayah_status += '</div>';
            filter_wilayah_status += '<div class="col-3 form-group">';
            filter_wilayah_status += '<label>@lang('label.provinsi')</label>';
            @if(request()->route()->getName() == "simple_cms.plugins.bkpmumkm.backend.survey.company.index" || request()->route()->getName() == "simple_cms.plugins.bkpmumkm.backend.survey.umkm.index")
                filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableProvinsi select2FilterDataTableProvinsi" name="provinsi_id">';
            @else
                filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableProvinsi" select2FilterDataTableProvinsi" name="provinsi_id">';
            @endif
            filter_wilayah_status += '<option value="all" selected>@lang('label.all_provinsi')</option>';
            filter_wilayah_status += '</select>';
            filter_wilayah_status += '</div>';    
            filter_wilayah_status += '<div class="col-3 form-group">';
            filter_wilayah_status += '<label>Status</label>';
            filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm" name="status_filter">';    
            filter_wilayah_status += '<option value="all">Semua Status</option>';             
            filter_wilayah_status += '<option value="bersedia">Bersedia</option>';             
            filter_wilayah_status += '<option value="tidak_bersedia">Belum Bersedia</option>';             
            filter_wilayah_status += '<option value="tidak_respon">Tidak Respon</option>';             
            filter_wilayah_status += '<option value="konsultasi_bkpm">Konsultasi BKPM</option>';             
            filter_wilayah_status += '<option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>';             
            filter_wilayah_status += '<option value="belum_terisi">Status Belum Terisi</option>';             
            filter_wilayah_status += '</select>';
            filter_wilayah_status += '</div>';        
        @endif

        $(document).on('click', '.eventCompanyChangeStatus', function (e) {
            let self = $(this),
                url = self.attr('data-action'),
                params = self.attr('data-value'),
                dataTableID = self.attr('data-selecteddatatable');
            params = (typeof params === "string" ? JSON.parse(params) : params);

            Swal.fire({
                title: params.name_company,
                html: 'Ubah status : <strong>'+ params.label_status +'</strong>',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#fa0202",
                confirmButtonText: 'Ubah.!',
                reverseButtons: true,
                preConfirm: () => {
                    return $.ajax({
                        url:url, type:'POST', typeData:'json',  cache:false, data:params,
                        success: function(data){
                            if (typeof window.LaravelDataTables !== "undefined" && typeof window.LaravelDataTables[dataTableID] !== "undefined"){
                                (window.LaravelDataTables[dataTableID]).draw();
                            }
                            return data;
                        }
                    });
                },
                allowOutsideClick: false
            }).then((result) => {
                if (result.value) {
                    simple_cms.responseMessageWithSwal(result.value);
                }
            });
        });
        
    </script>
    {!! library_datatables('js') !!}
    {!! $dataTable->scripts() !!}
    {!! module_script('core','js/events.js') !!}
@endpush
