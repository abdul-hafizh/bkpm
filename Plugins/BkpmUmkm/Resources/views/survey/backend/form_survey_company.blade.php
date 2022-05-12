@extends('core::layouts.backend')
@section('title', $title)
@push('body_class', 'sidebar-collapse')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans("label.survey_{$category_company}") }}"> {{ trans("label.survey_{$category_company}") }}</a></li>
    <li class="breadcrumb-item active"><a title="{{ $title }}"> {{ $title }}</a></li>
@endsection
@push('css_stack')
    {!! plugins_style('bkpmumkm', 'survey/backend/css/dropzone-style.css') !!}
    {!! library_select2('css') !!}
    {!! library_datepicker('css') !!}
    {!! library_leaflet('css') !!}
    {!! plugins_style('bkpmumkm', 'survey/backend/css/input-survey.css') !!}
@endpush

@section('layout')
    <div class="container-fluid">
        <div class="row mb-3 justify-content-center">
            <div class="col-md-10 col-sm-12 col-xs-12">
                <a class="btn btn-warning btn-sm" href="{{ route("{$bkpmumkm_identifier}.backend.survey.{$category_company}.index") }}" title="{{ trans('label.back') }}"><i class="fa fa-arrow-left"></i> {{ trans('label.back') }}</a>
            </div>
        </div>

        <form id="formInputSurvey" class="row justify-content-center" data-action="{{ route("{$bkpmumkm_identifier}.backend.survey.input_survey.save", ['company' => $category_company, 'survey' => encrypt_decrypt($survey->id)]) }}">
            <input type="hidden" name="id" value="{{ encrypt_decrypt($survey->survey_result->id) }}" />
            <input type="hidden" name="survey_id" value="{{ encrypt_decrypt($survey->id) }}" />
            <input type="hidden" name="company_id" value="{{ encrypt_decrypt($survey->company_id) }}" />
            <div class="col-md-10 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">PROFIL KEMITRAAN</h3>
                        <h3 class="text-center">KELOMPOK USAHA BESAR (UB)</h3>
                        <h3 class="text-center">MENDORONG INVESTASI BESAR BERMITRA DENGAN UMKM TAHUN {{ ($survey ? \Carbon\Carbon::parse($survey->created_at)->format('Y') : \Carbon\Carbon::now()->format('Y')) }}</h3>
                    </div>
                </div>

                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_profil_usaha")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_kebutuhan_kemitraan")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_kemitraan_sedang_berjalan")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_standar_kriteria_persyaratan")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.{$category_company}.forms.form_responden")
                @include("{$bkpmumkm_identifier}::survey.backend.partials.note_revision")

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <strong class="text-danger">**</strong>) {{ trans('message.survey_input_required') }}
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status_survey">Status</label>
                                    <select id="status_survey" name="status" class="form-control form-control-sm" required>
                                        @foreach($status_survey as $key => $status)
                                            <option value="{{ $key }}" {{ ($survey->status == $key ? 'selected':'') }}>{{ trans("label.survey_status_{$key}") }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-sm" title="{{ trans('label.save') }}"><i class="fa fa-save"></i> {{ trans('label.save') }}</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@push('js_stack')
    <script>
        window['wilayah'] = [
            'responden',
            'profil_usaha'
        ];
        const category_company = "{{ $category_company }}",
            labelDelete = "{{ trans('label.delete') }}",
            pathCompany = "{{ ($path_company ? $path_company:'') }}",
            label_kemitraan_berjalan_nilai_kontrak = "@lang('label.kemitraan_berjalan_nilai_kontrak')",
            label_kemitraan_berjalan_satuan = "@lang('label.kemitraan_berjalan_satuan')",
            label_kemitraan_berjalan_pengali = "@lang('label.kemitraan_berjalan_pengali')",
            label_kemitraan_berjalan_total_potensi_nilai = "@lang('label.kemitraan_berjalan_total_potensi_nilai')",
            business_sectors = @json($business_sectors);

        $(document).ready(function () {
            $(document).on('click', '.eventAddNewKebutuhanKemitraan', function (e) {
                e.stopPropagation();
                template_kebutuhan_kemitraan();
            });

            $(document).on('click', '.eventRemoveKebutuhanKemitraan', function (e) {
                e.stopPropagation();
                let self = $(this),
                    parent = self.parent().parent().parent(),
                    label = '';
                $.each(parent.find('input, textarea'), function(){
                    label += $(this).val();
                });
                if (label === ""){
                    parent.remove();
                    renumberingKebutuhanKemitraan();
                    hitung_kebutuhan_kemitraan_total_potensi_nilai();
                }else{
                    label = labelDelete + '.!?';
                    Swal.fire({
                        title: label,
                        text: '',
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#fa0202",
                        confirmButtonText: labelDelete,
                        reverseButtons: true,
                        preConfirm: () => {
                            return true;
                        },
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.value) {
                            parent.remove();
                            renumberingKebutuhanKemitraan();
                            hitung_kebutuhan_kemitraan_total_potensi_nilai();
                        }
                    });
                }
            });

            $(document).on('paste keydown keyup blur outblur focusout',
                "table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan > td > input.nilai_kontrak, table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan > td input.pengali_nilai_kontrak",
                function(){
                hitung_kebutuhan_kemitraan_total_potensi_nilai();
            });

            function renumberingKebutuhanKemitraan() {
                $.each($(`table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan`, document), function(idx, val){
                    $(this).find('input, textarea').each(function(){
                        this.name = this.name.replace(/\[\d+\]/, `[${(idx+1)}]`);
                    });
                });
                $('.total_data_kebutuhan_kemitraan', document).html('Total Data: ' + $('table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan', document).length);
            }
            function hitung_kebutuhan_kemitraan_total_potensi_nilai() {
                let total = 0;
                $.each($(`table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan`, document), function(idx, val){
                    let nominal = $(this).find('input.nilai_kontrak').val(),
                        pengali = $(this).find('input.pengali_nilai_kontrak').val();
                    pengali = pengali.replace(/,/g, '');
                    pengali = parseInt(pengali, 10);
                    nominal = nominal.replace(/,/g, '');
                    nominal = parseInt(nominal, 10);
                    let total_potensi_nilai = (nominal * pengali),
                        format_total_potensi_nilai = parseInt(total_potensi_nilai, 10) || 0;
                    $(this).find('input.total_potensi_nilai').val(format_total_potensi_nilai.toLocaleString());
                    total += total_potensi_nilai;
                });
                setTimeout(function(){
                    total = parseInt(total, 10) || 0;
                    $('.kebutuhan_kemitraan_total_potensi_nilai', document).html("Total Semua Potensi Nilai: " + total.toLocaleString());
                }, 800);
            }

            $(document).on('click', '.eventAddNewKemitraanSedangBerjalan', function (e) {
                e.stopPropagation();
                templateKemitraanSedangBerjalan();
            });

            $(document).on('click', '.eventRemoveKemitraanSedangBerjalan', function (e) {
                e.stopPropagation();
                let self = $(this),
                    parent = self.parent().parent().parent(),
                    label = '';
                $.each(parent.find('input, textarea'), function(){
                    label += $(this).val();
                });
                if (label === ""){
                    parent.remove();
                    renumberingKemitraanSedangBerjalan();
                    hitung_kemitraan_berjalan_total_potensi_nilai();
                }else{
                    label = labelDelete + '.!?';
                    Swal.fire({
                        title: label,
                        text: '',
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#fa0202",
                        confirmButtonText: labelDelete,
                        reverseButtons: true,
                        preConfirm: () => {
                            return true;
                        },
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.value) {
                            parent.remove();
                            renumberingKemitraanSedangBerjalan();
                            hitung_kemitraan_berjalan_total_potensi_nilai();
                        }
                    });
                }
            });

            function template_kebutuhan_kemitraan() {
                let html = '',
                    indexName = $('table > tbody.itemsKebutuhanKemitraan > tr.itemKebutuhanKemitraan', document).length + 1;
                    html += '<tr class="itemKebutuhanKemitraan row">\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <label class="d-md-none d-lg-none d-xl-none">Jenis Pekerjaan</label>\n' +
                    '           <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][jenis_pekerjaan]" value="" placeholder="Jenis Pekerjaan" class="form-control form-control-sm">\n' +
                    '       </td>\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <label class="d-md-none d-lg-none d-xl-none">Produk</label>\n' +
                    '           <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][produk]" value="" placeholder="Produk" class="form-control form-control-sm">\n' +
                    '       </td>\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <label class="d-md-none d-lg-none d-xl-none">Kapasitas</label>\n' +
                    '           <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][kapasitas]" value="" placeholder="Kapasitas" class="form-control form-control-sm">\n' +
                    '       </td>\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <label class="d-md-none d-lg-none d-xl-none">Spesifikasi/Persyaratan</label>\n' +
                    '           <textarea name="data[kebutuhan_kemitraan]['+ indexName +'][persyaratan]" rows="2" placeholder="Spesifikasi/Persyaratan" class="form-control form-control-sm"></textarea>\n' +
                    '       </td>\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="d-md-none d-lg-none d-xl-none">'+ kebutuhan_kemitraan_nilai_kontrak +'</label>\n' +
                    '               <input type="number" name="data[kebutuhan_kemitraan]['+ indexName +'][nilai]" value="0" placeholder="'+ kebutuhan_kemitraan_nilai_kontrak +'" class="form-control form-control-sm nilai_kontrak">\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="">Jenis Supply</label>\n' +                       
                    '               <select name="data[kebutuhan_kemitraan]['+ indexName +'][jenis_supply]" class="form-control form-control-sm" required>\n' +
                    '                   <option value="">Pilih Jenis Supply</option>\n' + 
                    '                   <option value="Rantai Pasok">Rantai Pasok</option>\n' +
                    '                   <option value="Bahan Baku Penolong">Bahan Baku Penolong</option>\n' +
                    '                   <option value="Jasa-jasa Lainnya">Jasa-jasa Lainnya</option>\n' +
                    '                </select>\n' +
                    '           </div>\n' +
                    '       </td>\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="">'+ kebutuhan_kemitraan_terms_of_payment +'</label>\n' +
                    '               <textarea name="data[kebutuhan_kemitraan]['+ indexName +'][terms_of_payment]" rows="2" placeholder="'+ kebutuhan_kemitraan_terms_of_payment +'" class="form-control form-control-sm"></textarea>\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="">'+ kebutuhan_kemitraan_satuan +'</label>\n' +
                    '               <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][satuan]" value="" placeholder="e.g: Hari/Bulan/Tahun/Ton" class="form-control form-control-sm">\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="">'+ kebutuhan_kemitraan_pengali +'</label>\n' +
                    '               <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][pengali]" value="0" placeholder="'+ kebutuhan_kemitraan_pengali +'" class="form-control form-control-sm nominal pengali_nilai_kontrak">\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="">'+ kebutuhan_kemitraan_total_potensi_nilai +'</label>\n' +
                    '               <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][total_potensi_nilai]" value="0" placeholder="'+ kebutuhan_kemitraan_total_potensi_nilai +'" class="form-control form-control-sm nominal total_potensi_nilai" readonly>\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <button type="button" class="btn btn-xs btn-danger eventRemoveKebutuhanKemitraan mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
                    '           </div>\n' +
                    '       </td>\n' +
                    '    </tr>\n';
                $('.itemsKebutuhanKemitraan').append(html);
                $('.total_data_kebutuhan_kemitraan', document).html('Total Data: ' + indexName);
            }

            function templateKemitraanSedangBerjalan() {
                let html = '',
                    indexName = $('table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan', document).length + 1;
                html += '<tr class="itemKemitraanSedangBerjalan row">\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <label class="d-md-none d-lg-none d-xl-none">Pola Kemitraan</label>\n' +
                    '           <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][pola_kemitraan]" value="" placeholder="Pola Kemitraan" class="form-control form-control-sm">\n' +
                    '       </td>\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <label class="d-md-none d-lg-none d-xl-none">Nama Perusahaan UMKM</label>\n' +
                    '           <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][nama_perusahaan]" value="" placeholder="Nama Perusahaan UMKM" class="form-control form-control-sm">\n' +
                    '       </td>\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="">Bidang Usaha</label>\n' +
                    '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][bidang_usaha]" value="" placeholder="Bidang Usaha" class="form-control form-control-sm">\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="">Jenis Pekerjaan</label>\n' +
                    '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][jenis_pekerjaan]" value="" placeholder="Jenis Pekerjaan" class="form-control form-control-sm">\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="">Spesifikasi/Persyaratan</label>\n' +
                    '               <textarea name="data[kemitraan_sedang_berjalan]['+ indexName +'][persyaratan]" rows="2" placeholder="Spesifikasi/Persyaratan" class="form-control form-control-sm"></textarea>\n' +
                    '           </div>\n' +
                    '       </td>\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <div class="form-group">\n' +
                    '               <label>Waktu Pelaksanaan</label>\n' +
                    '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][waktu_pelaksanaan]" value="" placeholder="Waktu Pelaksanaan" class="form-control form-control-sm">\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <label>No Telp UMKM</label>\n' +
                    '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][no_telp]" value="" placeholder="No Telp UMKM" class="form-control form-control-sm">\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <label>Alamat UMKM</label>\n' +
                    '               <textarea type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][alamat]" rows="2" placeholder="Alamat UMKM" class="form-control form-control-sm"></textarea>\n' +
                    '           </div>\n' +
                    '       </td>\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <label class="d-md-none d-lg-none d-xl-none">'+ label_kemitraan_berjalan_nilai_kontrak +'</label>\n' +
                    '           <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][nilai]" value="" placeholder="'+ label_kemitraan_berjalan_nilai_kontrak +'" class="form-control form-control-sm nominal kemitraan_berjalan_nilai_kontrak">\n' +
                    '       </td>\n' +
                    '       <td class="col-md-2 col-sm-12 col-xs-12">\n' +
                    '           <div class="form-group">\n' +
                    '               <label>Term of Payment</label>\n' +
                    '               <textarea name="data[kemitraan_sedang_berjalan]['+ indexName +'][term_of_payment]" rows="2" placeholder="Term of Payment" class="form-control form-control-sm"></textarea>\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="">'+ label_kemitraan_berjalan_satuan +'</label>\n' +
                    '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][satuan]" value="" placeholder="e.g: Hari/Bulan/Tahun/Ton" class="form-control form-control-sm">\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="">'+ label_kemitraan_berjalan_pengali +'</label>\n' +
                    '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][pengali]" value="0" placeholder="'+ label_kemitraan_berjalan_pengali +'" class="form-control form-control-sm nominal kemitraan_berjalan_pengali_nilai_kontrak">\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <label class="">'+ label_kemitraan_berjalan_total_potensi_nilai +'</label>\n' +
                    '               <input type="text" name="data[kemitraan_sedang_berjalan]['+ indexName +'][total_potensi_nilai]" value="0" placeholder="'+ label_kemitraan_berjalan_total_potensi_nilai +'" class="form-control form-control-sm nominal kemitraan_berjalan_total_potensi_nilai" readonly>\n' +
                    '           </div>\n' +
                    '           <div class="form-group">\n' +
                    '               <button type="button" class="btn btn-xs btn-danger eventRemoveKemitraanSedangBerjalan mt-3" title="'+ labelDelete +'"><i class="fas fa-trash"></i> '+ labelDelete +'</button>\n' +
                    '           </div>\n' +
                    '       </td>\n' +
                    '    </tr>';
                $('.itemsKemitraanSedangBerjalan').append(html);
                $('.total_data_kemitraan_berjalan', document).html('Total Data: ' + indexName);
            }

            $(document).on('paste keydown keyup blur outblur focusout',
                "table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan > td > input.kemitraan_berjalan_nilai_kontrak, table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan > td input.kemitraan_berjalan_pengali_nilai_kontrak",
            function(){
                hitung_kemitraan_berjalan_total_potensi_nilai();
            });

            function renumberingKemitraanSedangBerjalan() {
                $.each($(`table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan`, document), function(idx, val){
                    $(this).find('input, textarea').each(function(){
                        this.name = this.name.replace(/\[\d+\]/, `[${(idx+1)}]`);
                    });
                });
                $('.total_data_kemitraan_berjalan', document).html('Total Data: ' + $('table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan', document).length);
            }
            function hitung_kemitraan_berjalan_total_potensi_nilai() {
                let total = 0;
                $.each($(`table > tbody.itemsKemitraanSedangBerjalan > tr.itemKemitraanSedangBerjalan`, document), function(idx, val){
                    let nominal = $(this).find('input.kemitraan_berjalan_nilai_kontrak').val(),
                        pengali = $(this).find('input.kemitraan_berjalan_pengali_nilai_kontrak').val();
                    pengali = pengali.replace(/,/g, '');
                    pengali = parseInt(pengali, 10);
                    nominal = nominal.replace(/,/g, '');
                    nominal = parseInt(nominal, 10);
                    let total_potensi_nilai = (nominal * pengali),
                        format_total_potensi_nilai = parseInt(total_potensi_nilai, 10) || 0;
                    $(this).find('input.kemitraan_berjalan_total_potensi_nilai').val(format_total_potensi_nilai.toLocaleString());
                    total += total_potensi_nilai;
                });
                setTimeout(function(){
                    total = parseInt(total, 10) || 0;
                    $('.kemitraan_berjalan_total_potensi_nilai_end', document).html("Total Semua Potensi Nilai: " + total.toLocaleString());
                }, 800);
            }
        });
    </script>
    {!! library_datepicker('js') !!}
    {!! library_select2('js') !!}
    {!! library_tinymce('js') !!}
    {!! library_leaflet('js') !!}
    {!! filemanager_standalonepopup() !!}
    {!! module_script('wilayah', 'js/event-wilayah.js') !!}
    {!! plugins_script('bkpmumkm', 'survey/backend/js/dropzone.js') !!}
    {!! plugins_script('bkpmumkm', 'survey/backend/js/input-survey.js') !!}
    {!! plugins_script('bkpmumkm', "survey/backend/js/input-survey-umkm.js") !!}
@endpush
