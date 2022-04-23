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
