{!! library_datatables('css') !!}
<div class="modal-body">
    {!! $dataTable->table() !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Close</button>
</div>
{!! library_datatables('js') !!}
{!! $dataTable->scripts() !!}
{!! module_script('core','js/events.js') !!}
<script>
    $(document).ready(function() {
        $('.selectTrashedDatable', document).remove();

        const label_all_provinsi = '@lang('label.all_provinsi')';
        let filter_wilayah_status = '',
            dataTableID = $(document).find('table.dataTable').attr('id');
        @if(in_array(auth()->user()->group_id, [GROUP_QC_KORWIL,GROUP_ASS_KORWIL,GROUP_TA,GROUP_SUPER_ADMIN,GROUP_ADMIN]))
            filter_wilayah_status += '<div class="col-3 form-group">';
            filter_wilayah_status += '<label>@lang('label.wilayah')</label>';
            filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableWilayah" name="wilayah_id">';
            @foreach(list_bkpmumkm_wilayah_by_user() as $wilayah_filter)
                filter_wilayah_status += '<option value="{{ $wilayah_filter['id'] }}" data-provinces=\'@json($wilayah_filter['provinces'])\'>{{ $wilayah_filter['name'] }}</option>';
            @endforeach
                filter_wilayah_status += '</select>';
            filter_wilayah_status += '</div>';
            filter_wilayah_status += '<div class="col-3 form-group">';
            filter_wilayah_status += '<label>@lang('label.provinsi')</label>';
            filter_wilayah_status += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm filterDataTableProvinsi" name="provinsi_id">';
            filter_wilayah_status += '<option value="all">@lang('label.all_provinsi')</option>';
            filter_wilayah_status += '</select>';
            filter_wilayah_status += '</div>';
        @endif
        $(`form#${dataTableID}Form`).append(filter_wilayah_status);

        $(document).on('change', 'select.filterDataTableWilayah', function(){
            let self = $(this),
                selectProvinsiOption = '<option value="all">'+label_all_provinsi +'</option>',
                provinces = $('select.filterDataTableWilayah > option:selected', document).attr('data-provinces');
            provinces = (typeof provinces === "string" ? JSON.parse(provinces):provinces);
            if (provinces.length) {
                $.each(provinces, function(idx, val){
                    selectProvinsiOption += `<option value="${val.kode_provinsi}">${val.nama_provinsi}</option>`;
                });
            }
            $('select.filterDataTableProvinsi', document).html(selectProvinsiOption);
        });
    });
</script>
