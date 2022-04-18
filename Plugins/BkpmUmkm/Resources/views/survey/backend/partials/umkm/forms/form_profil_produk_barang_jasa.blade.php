<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">4. Profil Produk Barang/Jasa yang Dihasilkan <button type="button" class="btn btn-xs btn-primary eventAddNewProdukBarangJasa" title="{{ trans('label.add_new') }}"><i class="fas fa-plus"></i> {{ trans('label.add_new') }}</button></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="d-none d-md-block">
            <tr class="row">
                <th class="col-md-3 col-sm-12 col-xs-12">Produk Barang/Jasa</th>
                <th class="col-md-4 col-sm-12 col-xs-12">Deskripsi & Spesifikasi Produk Barang/Jasa</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Kapasitas Produksi per bulan</th>
                <th class="col-md-3 col-sm-12 col-xs-12">**Foto/Dokumen</th>
            </tr>
            </thead>
            <tbody class="itemsProdukBarangJasa">
            @php
                $profil_produk_barang_jasa    = ($survey->survey_result->data && (isset($survey->survey_result->data['profil_produk_barang_jasa'])&&$survey->survey_result->data['profil_produk_barang_jasa']) ? $survey->survey_result->data['profil_produk_barang_jasa'] : []);
                $index_ppbj = 1;
            @endphp
            @foreach($profil_produk_barang_jasa as $key => $ppbj)
                <tr class="itemProdukBarangJasa row">
                    <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Produk Barang/Jasa</label>
                        <input type="text" name="data[profil_produk_barang_jasa][{{ $index_ppbj }}][nama]" value="{{ (isset($ppbj['nama'])?$ppbj['nama']:'') }}" placeholder="Produk Barang/Jasa" class="form-control form-control-sm">
                        <button type="button" class="btn btn-xs btn-danger eventRemoveProdukBarangJasa mt-3" title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                    </td>
                    <td class="col-md-4 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Deskripsi & Spesifikasi Produk Barang/Jasa</label>
                        <textarea name="data[profil_produk_barang_jasa][{{ $index_ppbj }}][deskripsi]" rows="2" placeholder="Deskripsi & Spesifikasi Produk Barang/Jasa" class="form-control form-control-sm">{!! nl2br((isset($ppbj['deskripsi'])?$ppbj['deskripsi']:'')) !!}</textarea>
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Kapasitas Produksi per bulan</label>
                        <input type="text" name="data[profil_produk_barang_jasa][{{ $index_ppbj }}][kapasitas]" value="{{ (isset($ppbj['kapasitas'])?$ppbj['kapasitas']:'') }}" placeholder="Kapasitas Produksi per bulan" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-3 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-12 d-md-none d-lg-none d-xl-none"><label>**Foto/Dokumen</label></div>
                            <div class="myDropZone myDropZoneSingle col-12">
                                <input type="file" name="data[profil_produk_barang_jasa][{{ $index_ppbj }}][foto_dokumen_upload][]" data-named="data[profil_produk_barang_jasa][{{ $index_ppbj }}][foto_dokumen][][file]" data-index="data.profil_produk_barang_jasa.{{ $index_ppbj }}.foto_dokumen" multiple>
                            </div>
                            <div class="col-12 mt-2">
                                @php
                                    $profil_produk_barang_jasa_foto_dokumen    = (isset($ppbj['foto_dokumen'])?$ppbj['foto_dokumen']: []);
                                @endphp
                                <div class="row myDropZoneView">
                                    @foreach($profil_produk_barang_jasa_foto_dokumen as $foto_dokumen)
                                        <div class="col-lg-3 col-md-4 col-6 mb-3">
                                            <input type="hidden" name="data[profil_produk_barang_jasa][{{ $index_ppbj }}][foto_dokumen][][file]" value="{{ $foto_dokumen['file'] }}">
                                            <div class="mdz-image">
                                                <img src="{{ view_asset($foto_dokumen['file']) }}" class="img-thumbnail"/>
                                            </div>
                                            <div class="mdz-footer text-right">
                                                <button type="button" class="btn btn-danger btn-xs btn-block eventRemoveMdzFile" data-value='@json(['file_delete' => "{$foto_dokumen['file']}"])' title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @php $index_ppbj++; @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr class="row">
                <th colspan="4" class="col-md-12 col-sm-12 col-xs-12 text-left total_data_profil_produk_barang_jasa">Total Data: {{ count($profil_produk_barang_jasa) }}</th>
            </tr>
            </tfoot>
        </table>

        <p class="text-justify">Catatan: **)Mohon sampaikan kepada surveyor foto produk ataupun dokumen-mengenai produk barang/jasa yang dilayani untuk didokumentasikan.</p>

    </div>
</div>
