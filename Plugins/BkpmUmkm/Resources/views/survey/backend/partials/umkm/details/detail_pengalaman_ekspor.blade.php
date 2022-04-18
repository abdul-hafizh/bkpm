<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">5. Pengalaman Ekspor</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead class="d-none d-md-block">
            <tr class="row">
                <th class="col-md-4 col-sm-12 col-xs-12">Jenis Produk</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Negara Tujuan Ekspor</th>
                <th class="col-md-4 col-sm-12 col-xs-12">Nilai Ekspor</th>
                <th class="col-md-2 col-sm-12 col-xs-12">Tahun</th>
            </tr>
            </thead>
            <tbody class="">
            @php
                $pengalaman_ekspor    = ($survey->survey_result->data && (isset($survey->survey_result->data['pengalaman_ekspor'])&&$survey->survey_result->data['pengalaman_ekspor']) ? $survey->survey_result->data['pengalaman_ekspor'] : []);
            @endphp
            @foreach($pengalaman_ekspor as $pe)
                <tr class="row">
                    <td class="col-md-4 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Jenis Produk</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($pe['jenis_produk'])?$pe['jenis_produk']:'-') }}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Negara Tujuan Ekspor</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($pe['negara_tujuan'])?$pe['negara_tujuan']:'-') }}
                    </td>
                    <td class="col-md-4 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Nilai Ekspor</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($pe['nilai'])? $pe['nilai']:'-') }}
                    </td>
                    <td class="col-md-2 col-sm-12 col-xs-12">
                        <label class="d-md-none d-lg-none d-xl-none">Tahun</label>
                        <br class="d-md-none d-lg-none d-xl-none"/>
                        {{ (isset($pe['tahun'])?$pe['tahun']:'-') }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
