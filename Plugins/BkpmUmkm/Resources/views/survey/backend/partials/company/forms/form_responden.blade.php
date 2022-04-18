@php
    $responden = ($survey->survey_result->data && (isset($survey->survey_result->data['responden'])&&$survey->survey_result->data['responden']) ? $survey->survey_result->data['responden']: '');
@endphp
<div class="card">
    <div class="card-body">
        <table class="table table-sm">
            <thead>
            <tr>
                <th style="width: 50%;"></th>
                <th style="width: 50%;"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Dibuat di <input type="text" name="data[responden][dibuat_di]" value="{{ (isset($responden['dibuat_di']) ? $responden['dibuat_di'] : '') }}" placeholder="Dibuat di" class="form-control form-control-sm"></td>
                <td>tanggal <input type="text" name="data[responden][tanggal]" value="{{ (isset($responden['tanggal']) ? \Carbon\Carbon::parse($responden['tanggal'])->format('d-m-Y') : \Carbon\Carbon::now()->format('d-m-Y')) }}" placeholder="tanggal" class="form-control form-control-sm datepickerInit"></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">Responden</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
            <tr>
                <th style="width: 20%;"></th>
                <th style="width: 2%;"></th>
                <th style="width: 78%;"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Nama <strong class="text-danger">**</strong> </td>
                <td>:</td>
                <td>
                    <input type="text" name="data[responden][nama_responden]" value="{{ (isset($responden['nama_responden']) ? $responden['nama_responden'] : '') }}" placeholder="Nama Responden" class="form-control form-control-sm">
                </td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>
                    <input type="text" name="data[responden][jabatan]" value="{{ (isset($responden['jabatan']) ? $responden['jabatan'] : '') }}" placeholder="Jabatan" class="form-control form-control-sm">
                </td>
            </tr>
            <tr>
                <td>Nomor Ponsel <strong class="text-danger">**</strong></td>
                <td>:</td>
                <td>
                    <input type="text" name="data[responden][nomor_ponsel]" value="{{ (isset($responden['nomor_ponsel']) ? $responden['nomor_ponsel'] : '') }}" placeholder="Nomor Ponsel" class="form-control form-control-sm">
                </td>
            </tr>
            <tr>
                <td>Email <strong class="text-danger">**</strong></td>
                <td>:</td>
                <td>
                    <input type="email" name="data[responden][email]" value="{{ (isset($responden['email']) ? $responden['email'] : '') }}" placeholder="Email" class="form-control form-control-sm">
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
