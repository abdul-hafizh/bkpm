<div class="form-group">
    <label for="id_negara_{{ $key }}">{{ trans('wilayah::label.country') }}  {!! $negara_required ? '<i class="text-danger">*</i>' : '' !!}</label>
    <select id="id_negara_{{ $key }}" class="form-control select2InitB4 selectWilayah wilayah_negara" data-wilayah-off="{{ $key }}" name="id_negara{{ $key_name }}" data-value='{"selected":"{{ $id_provinsi }}","to":"provinsi"}' {{ $negara_required ? 'required' : '' }}>
        <option value="">-Pilih-</option>
        @foreach($negara as $ngr)
            <option value="{{ $ngr->kode_negara }}" {{ ($id_negara == $ngr->kode_negara ? 'selected':'') }}>{{ $ngr->nama_negara }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="id_provinsi_{{ $key }}">{{ trans('wilayah::label.province') }}  {!! $provinsi_required ? '<i class="text-danger">*</i>' : '' !!}</label>
    <select id="id_provinsi_{{ $key }}" class="form-control select2InitB4 selectWilayah wilayah_provinsi" data-wilayah-off="{{ $key }}" name="id_provinsi{{ $key_name }}" data-value='{"selected":"{{ $id_kabupaten }}","to":"kabupaten"}' {{ $provinsi_required ? 'required' : '' }}>
        <option value="">-Pilih-</option>
    </select>
</div>
<div class="form-group">
    <label for="id_kabupaten_{{ $key }}">{{ trans('wilayah::label.city_district') }} {!! $kabupaten_required ? '<i class="text-danger">*</i>' : '' !!}</label>
    <select id="id_kabupaten_{{ $key }}" class="form-control select2InitB4 selectWilayah wilayah_kabupaten" data-wilayah-off="{{ $key }}" name="id_kabupaten{{ $key_name }}" data-value='{"selected":"{{ $id_kecamatan }}","to":"kecamatan"}' {{ $kabupaten_required ? 'required' : '' }}>
        <option value="">-Pilih-</option>
    </select>
</div>
<div class="form-group">
    <label for="id_kecamatan_{{ $key }}">{{ trans('wilayah::label.sub_district') }} {!! $kecamatan_required ? '<i class="text-danger">*</i>' : '' !!}</label>
    <select id="id_kecamatan_{{ $key }}" class="form-control select2InitB4 selectWilayah wilayah_kecamatan" data-wilayah-off="{{ $key }}" name="id_kecamatan{{ $key_name }}" data-value='{"selected":"{{ $id_desa }}","to":"desa"}' {{ $kecamatan_required ? 'required' : '' }}>
        <option value="">-Pilih-</option>
    </select>
</div>
<div class="form-group">
    <label for="id_desa_{{ $key }}">{{ trans('wilayah::label.village') }} {!! $desa_required ? '<i class="text-danger">*</i>' : '' !!}</label>
    <select id="id_desa_{{ $key }}" class="form-control select2InitB4 selectWilayah wilayah_desa" data-wilayah-off="{{ $key }}" name="id_desa{{ $key_name }}" data-value='{"selected":"","to":""}' {{ $desa_required ? 'required' : '' }}>
        <option value="">-Pilih-</option>
    </select>
</div>
<script>
    if(typeof window['wilayah'] === "undefined"){
        window['wilayah'] = new Array();
    }
    window['wilayah'].push('{{ $key }}');
</script>
