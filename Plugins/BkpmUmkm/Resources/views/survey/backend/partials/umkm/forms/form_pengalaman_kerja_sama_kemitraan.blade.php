<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">7. Pengalaman Kerja Sama/Kemitraan (maksimal 5 kerja sama/kemitraan Terakhir) <button type="button" class="btn btn-xs btn-primary eventAddNewPengalamanKerjaSamaKemitraan" title="{{ trans('label.add_new') }}"><i class="fas fa-plus"></i> {{ trans('label.add_new') }}</button></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="d-none d-md-block">
            <tr class="row">
                <th class="col-md-3 col-sm-12 col-xs-12">Nama Mitra/Buyer</th>
                <th class="col-md-2 col-sm-12 col-xs-12">**Bentuk Kerja Sama/kemitraan</th>
                <th class="col-md-1 col-sm-12 col-xs-12">Tahun</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Nilai Kerja Sama</th>
                <th class="col-md-4 col-sm-12 col-xs-12">Keterangan</th>
            </tr>
            </thead>
            <tbody class="itemsPengalamanKerjaSamaKemitraan">
            @php
                $pengalaman_kerja_sama_kemitraan    = ($survey->survey_result->data && (isset($survey->survey_result->data['pengalaman_kerja_sama_kemitraan'])&&$survey->survey_result->data['pengalaman_kerja_sama_kemitraan']) ? $survey->survey_result->data['pengalaman_kerja_sama_kemitraan'] : []);
                $index_pksk = 1;
                $pengalaman_kerja_sama_kemitraan_total_nilai = 0;
            @endphp
            @foreach($pengalaman_kerja_sama_kemitraan as $k_pksk => $pksk)
                <tr class="itemPengalamanKerjaSamaKemitraan row">
                    <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Nama Mitra/Buyer</label>
                        <input type="text" name="data[pengalaman_kerja_sama_kemitraan][{{ $index_pksk }}][nama_mitra]" value="{{ (isset($pksk['nama_mitra'])?$pksk['nama_mitra']:'') }}" placeholder="Nama Mitra/Buyer" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">**Bentuk Kerja Sama/kemitraan</label>
                        <input type="text" name="data[pengalaman_kerja_sama_kemitraan][{{ $index_pksk }}][bentuk_kerja_sama]" value="{{ (isset($pksk['bentuk_kerja_sama'])?$pksk['bentuk_kerja_sama']:'') }}" placeholder="**Bentuk Kerja Sama/kemitraan" class="form-control form-control-sm">
                    </td>
                    <td class="col-md-1 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Tahun</label>
                        <input type="text" name="data[pengalaman_kerja_sama_kemitraan][{{ $index_pksk }}][tahun]" value="{{ (isset($pksk['tahun'])?$pksk['tahun']:'') }}" placeholder="Tahun" class="form-control form-control-sm numberonly">
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Nilai Kerja Sama</label>
                        <input type="text" name="data[pengalaman_kerja_sama_kemitraan][{{ $index_pksk }}][nilai]" value="{{ (isset($pksk['nilai'])?$pksk['nilai']:'') }}" placeholder="Nilai Kerja Sama" class="form-control form-control-sm nominal">
                    </td>
                    <td class="col-md-4 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Keterangan</label>
                        <textarea name="data[pengalaman_kerja_sama_kemitraan][{{ $index_pksk }}][keterangan]" placeholder="Keterangan" rows="2" class="form-control form-control-sm">{!! nl2br(isset($pksk['keterangan'])?$pksk['keterangan']:'') !!}</textarea>
                        <button type="button" class="btn btn-xs btn-danger eventRemovePengalamanKerjaSamaKemitraan mt-3" title="{{ trans('label.delete') }}"><i class="fas fa-trash"></i> {{ trans('label.delete') }}</button>
                    </td>
                </tr>
                @php
                    $pengalaman_kerja_sama_kemitraan_total_nilai += (int) (isset($pksk['nilai'])&&!empty($pksk['nilai'])? str_replace([',','.'], '', $pksk['nilai']):0);
                    $index_pksk++;
                @endphp
            @endforeach
            </tbody>
            <tfoot>
            <tr class="row">
                <th colspan="2" class="col-md-6 col-sm-12 col-xs-12 text-left total_data_pengalaman_kerja_sama_kemitraan">Total Data: {{ count($pengalaman_kerja_sama_kemitraan) }}</th>
                <th colspan="1" class="col-md-6 col-sm-12 col-xs-12 text-left pengalaman_kerja_sama_kemitraan_total_nilai">Total Nilai: {{ number_format($pengalaman_kerja_sama_kemitraan_total_nilai) }}</th>
            </tr>
            </tfoot>
        </table>
        <p class="text-justify">Catatan: **) Bentuk kerja sama/kemitraan dapat berupa inti-plasma, subkontrak, waralaba, perdagangan umum, distribusi dan keagenan, rantai pasok, bagi hasil, kerja sama operasional, usaha patungan, penyumberluaran (outsourcing), dan pola kemitraan lainnya.</p>
    </div>
</div>
