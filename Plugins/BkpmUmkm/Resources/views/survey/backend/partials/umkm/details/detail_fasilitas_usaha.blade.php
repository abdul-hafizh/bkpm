<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">6. Fasilitas Usaha</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="d-none d-md-block">
            <tr class="row">
                <th class="col-md-3 col-sm-12 col-xs-12">Jenis Kegiatan Kerja</th>
                <th class="col-md-6 col-sm-12 col-xs-12">Peralatan/Mesin yang Digunakan</th>
                <th class="col-md-3 col-sm-12 col-xs-12">Perkiraan Nilai (Rp)</th>
            </tr>
            </thead>
            <tbody class="">
            @php
                $fasilitas_usaha    = ($survey->survey_result->data && (isset($survey->survey_result->data['fasilitas_usaha'])&&$survey->survey_result->data['fasilitas_usaha']) ? $survey->survey_result->data['fasilitas_usaha']: []);
            @endphp
            @foreach($fasilitas_usaha as $fu)
                <tr class="row">
                    <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Jenis Kegiatan Kerja</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($fu['jenis_kegiatan'])?$fu['jenis_kegiatan']:'-') }}
                    </td>
                    <td class="col-md-6 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Peralatan/Mesin yang Digunakan</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {!! nl2br(strip_tags(isset($fu['peralatan_mesin'])?$fu['peralatan_mesin']:'-')) !!}
                    </td>
                    <td class="col-md-3 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Perkiraan Nilai (Rp)</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($fu['nilai'])?$fu['nilai']:'-') }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p class="text-justify">Catatan: Mohon menjelaskan aset yang dimiliki berdasarkan urut-urutan kegiatan yang dijalankan untuk menghasilkan produk/jasa.</p>
    </div>
</div>
