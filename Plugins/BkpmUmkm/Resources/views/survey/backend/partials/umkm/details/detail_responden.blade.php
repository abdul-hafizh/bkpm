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
                <td>Dibuat di : {{ (isset($responden['dibuat_di']) ? $responden['dibuat_di'] : '-') }}</td>
                <td>tanggal : {{ (isset($responden['tanggal']) ? \Carbon\Carbon::parse($responden['tanggal'])->format('d-m-Y') : '-') }}</td>
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
                <td>Nama  </td>
                <td>:</td>
                <td>
                    {{ (isset($responden['nama_responden']) ? $responden['nama_responden'] : '-') }}
                </td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>
                    {{ (isset($responden['jabatan']) ? $responden['jabatan'] : '-') }}
                </td>
            </tr>
            <tr>
                <td>Nomor Ponsel </td>
                <td>:</td>
                <td>
                    {{ (isset($responden['nomor_ponsel']) ? $responden['nomor_ponsel'] : '-') }}
                </td>
            </tr>
            <tr>
                <td>Email </td>
                <td>:</td>
                <td>
                    {{ (isset($responden['email']) ? $responden['email'] : '-') }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
