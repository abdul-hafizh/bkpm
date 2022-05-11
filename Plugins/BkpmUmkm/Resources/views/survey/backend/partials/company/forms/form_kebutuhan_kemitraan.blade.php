<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">2. Kebutuhan Kemitraan dengan UMKM <button type="button" class="btn btn-xs btn-primary eventAddNewKebutuhanKemitraan" title="{{ trans('label.add_new') }}"><i class="fas fa-plus"></i> {{ trans('label.add_new') }}</button></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="d-none d-md-block">
            <tr class="row">
                <th class="col-md-2 col-sm-12 col-xs-12">Jenis Pekerjaan</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Produk</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Kapasitas</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Spesifikasi/Persyaratan</th>
                <th class="col-md-2 col-sm-12 col-xs-12">@lang('label.kebutuhan_kemitraan_nilai_kontrak')</th>
                <th class="col-md-2 col-sm-12 col-xs-12">@lang('label.kebutuhan_kemitraan_lain_lain')</th>
            </tr>
            </thead>
            <tbody class="itemsKebutuhanKemitraan">
            @php
                $kebutuhan_kemitraan    = ($survey->survey_result->data && (isset($survey->survey_result->data['kebutuhan_kemitraan'])&&$survey->survey_result->data['kebutuhan_kemitraan']) ? $survey->survey_result->data['kebutuhan_kemitraan'] : []);
                $index_kk = 1;
                $kebutuhan_kemitraan_total_potensi_nilai = 0;
            @endphp
            @foreach($kebutuhan_kemitraan as $k_kk => $kk)
                <tr class="itemKebutuhanKemitraan row">
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Jenis Pekerjaan</label>
                        <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][jenis_pekerjaan]" value="{{ (isset($kk['jenis_pekerjaan'])?$kk['jenis_pekerjaan']:'') }}" placeholder="Jenis Pekerjaan" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Produk</label>
                        <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][produk]" value="{{ (isset($kk['produk'])?$kk['produk']:'') }}" placeholder="Produk" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Kapasitas</label>
                        <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][kapasitas]" value="{{ (isset($kk['kapasitas'])?$kk['kapasitas']:'') }}" placeholder="Kapasitas" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Spesifikasi/Persyaratan</label>
                        <textarea name="data[kebutuhan_kemitraan][{{ $index_kk }}][persyaratan]" rows="2" placeholder="Spesifikasi/Persyaratan" class="form-control form-control-sm">{!! nl2br(isset($kk['persyaratan'])?$kk['persyaratan']:'') !!}</textarea>
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="d-md-none d-lg-none d-xl-none">@lang('label.kebutuhan_kemitraan_nilai_kontrak')</label>
                            <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][nilai]" value="{{ (isset($kk['nilai'])?$kk['nilai']:'0') }}" placeholder="@lang('label.kebutuhan_kemitraan_nilai_kontrak')" class="form-control form-control-sm nominal nilai_kontrak">                        
                        </div>
                        <div class="form-group">
                            <label class="">Jenis Supply</label>                            
                            <select name="data[kebutuhan_kemitraan][{{ $index_kk }}][jenis_supply]" class="form-control form-control-sm" required>
                                <option value="">Pilih Jenis Supply</option>                                                                                                    
                                @if(isset($kk['jenis_supply']))
                                    <option value="Rantai Pasok" {{ $kk['jenis_supply'] == 'Rantai Pasok' ? 'selected' : '' }}>Rantai Pasok</option>
                                    <option value="Bahan Baku Penolong" {{ $kk['jenis_supply'] == 'Bahan Baku Penolong' ? 'selected' : '' }}>Bahan Baku Penolong</option>
                                    <option value="Jasa-jasa Lainnya" {{ $kk['jenis_supply'] == 'Jasa-jasa Lainnya' ? 'selected' : '' }}>Jasa-jasa Lainnya</option>                                    
                                @else 
                                    <option value="Rantai Pasok">Rantai Pasok</option>
                                    <option value="Bahan Baku Penolong">Bahan Baku Penolong</option>
                                    <option value="Jasa-jasa Lainnya">Jasa-jasa Lainnya</option>
                                @endif                     
                            </select>
                        </div>
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_terms_of_payment')</label>
                            <textarea name="data[kebutuhan_kemitraan][{{ $index_kk }}][terms_of_payment]" rows="2" placeholder="@lang('label.kebutuhan_kemitraan_terms_of_payment')" class="form-control form-control-sm">{!! nl2br(isset($kk['terms_of_payment'])?$kk['terms_of_payment']:'') !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_satuan')</label>
                            <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][satuan]" value="{{ (isset($kk['satuan'])?$kk['satuan']:'') }}" placeholder="e.g: Hari/Bulan/Tahun/Ton" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_pengali')</label>
                            <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][pengali]" value="{{ (isset($kk['pengali'])?$kk['pengali']:0) }}" placeholder="@lang('label.kebutuhan_kemitraan_pengali')" class="form-control form-control-sm nominal pengali_nilai_kontrak">
                        </div>
                        <div class="form-group">
                            <label class="">@lang('label.kebutuhan_kemitraan_total_potensi_nilai')</label>
                            <input type="text" name="data[kebutuhan_kemitraan][{{ $index_kk }}][total_potensi_nilai]" value="{{ (isset($kk['total_potensi_nilai'])?$kk['total_potensi_nilai']:0) }}" placeholder="@lang('label.kebutuhan_kemitraan_total_potensi_nilai')" class="form-control form-control-sm nominal total_potensi_nilai">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-xs btn-danger eventRemoveKebutuhanKemitraan mt-3" title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                        </div>
                    </td>
                </tr>
                @php
                    $kebutuhan_kemitraan_total_potensi_nilai += (int) (isset($kk['total_potensi_nilai'])&&!empty($kk['total_potensi_nilai'])? str_replace([',','.'], '', $kk['total_potensi_nilai']):0);
                    $index_kk++;
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr class="row">
                <th colspan="2" class="col-md-6 col-sm-12 col-xs-12 text-left total_data_kebutuhan_kemitraan">Total Data: {{ count($kebutuhan_kemitraan) }}</th>
                <th colspan="4" class="col-md-6 col-sm-12 col-xs-12 text-right kebutuhan_kemitraan_total_potensi_nilai">Total Semua Potensi Nilai: {{ number_format($kebutuhan_kemitraan_total_potensi_nilai) }}</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>
    const kebutuhan_kemitraan_nilai_kontrak = '@lang('label.kebutuhan_kemitraan_nilai_kontrak')',
    kebutuhan_kemitraan_terms_of_payment = '@lang('label.kebutuhan_kemitraan_terms_of_payment')',
    kebutuhan_kemitraan_satuan = '@lang('label.kebutuhan_kemitraan_satuan')',
    kebutuhan_kemitraan_pengali = '@lang('label.kebutuhan_kemitraan_pengali')',
    kebutuhan_kemitraan_total_potensi_nilai = '@lang('label.kebutuhan_kemitraan_total_potensi_nilai')';

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
                '               <input type="text" name="data[kebutuhan_kemitraan]['+ indexName +'][nilai]" value="0" placeholder="'+ kebutuhan_kemitraan_nilai_kontrak +'" class="form-control form-control-sm nominal nilai_kontrak">\n' +
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
