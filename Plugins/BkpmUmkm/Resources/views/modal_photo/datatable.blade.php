{!! library_datatables('css') !!}
<div class="modal-body">
    {!! $dataTable->table() !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Close</button>
</div>
<script>
    $(document).ready(function(){
        $('.selectTrashedDatable', document).remove();
		// $('.toolbar-button-datatable', document).remove();
		// $('.dataTables_filter', document).remove();
		// $('.dataTables_length', document).remove();
		// $('.dataTables_info', document).remove();
		// $('.dataTables_paginate', document).remove();
		// $('.paging_simple_numbers', document).remove();
    });
</script>
{!! library_datatables('js') !!}
{!! $dataTable->scripts() !!}
{!! module_script('core','js/events.js') !!}
