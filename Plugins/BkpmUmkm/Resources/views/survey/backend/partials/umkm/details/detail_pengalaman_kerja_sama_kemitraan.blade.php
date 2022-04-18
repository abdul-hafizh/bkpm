<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">7. Pengalaman Kerja Sama/Kemitraan (maksimal 5 kerja sama/kemitraan Terakhir)</h3>
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
            <tbody class="">
            @php
                $pengalaman_kerja_sama_kemitraan    = ($survey->survey_result->data && (isset($survey->survey_result->data['pengalaman_kerja_sama_kemitraan'])&&$survey->survey_result->data['pengalaman_kerja_sama_kemitraan']) ? $survey->survey_result->data['pengalaman_kerja_sama_kemitraan'] : []);
            @endphp
            @foreach($pengalaman_kerja_sama_kemitraan as $pksk)
                <tr class="row">
                    <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Nama Mitra/Buyer</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($pksk['nama_mitra'])?$pksk['nama_mitra']:'-') }}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">**Bentuk Kerja Sama/kemitraan</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($pksk['bentuk_kerja_sama'])?$pksk['bentuk_kerja_sama']:'-') }}
                    </td>
                    <td class="col-md-1 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Tahun</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($pksk['tahun'])?$pksk['tahun']:'-') }}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Nilai Kerja Sama</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($pksk['nilai'])? $pksk['nilai']:'-') }}
                    </td>
                    <td class="col-md-4 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Keterangan</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>{!! nl2br(isset($pksk['keterangan'])?$pksk['keterangan']:'') !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p class="text-justify">Catatan: **) Bentuk kerja sama/kemitraan dapat berupa inti-plasma, subkontrak, waralaba, perdagangan umum, distribusi dan keagenan, rantai pasok, bagi hasil, kerja sama operasional, usaha patungan, penyumberluaran (outsourcing), dan pola kemitraan lainnya.</p>
    </div>
</div>
