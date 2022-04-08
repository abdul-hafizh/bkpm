/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 3:06 PM ---------
 */

$(document).ready(function () {
    let dataTableID = $(document).find('table.dataTable').attr('id'),
        periode = '<div class="form-group col-2">';
    periode += '<label>Periode</label>';
    periode += '<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm" name="periode">';
    $.each(periodes, function(idx, val){
        periode += '<option value="'+ val +'">'+ val +'</option>';
    });
    periode += '</select>';
    periode += '</div>';

    $(`form#${dataTableID}Form`).append(periode);

});
