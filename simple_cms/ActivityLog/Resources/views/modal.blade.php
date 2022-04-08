{!! library_datatables('css') !!}
<div class="modal-body">
    {!! $dataTable->table() !!}
</div>
{!! library_datatables('js') !!}
{!! $dataTable->scripts() !!}