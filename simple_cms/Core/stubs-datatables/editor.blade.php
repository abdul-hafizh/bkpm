(function(window,$){
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {let optionsSwal = {title: 'DataTable Error', html:message};if(typeof settings.jqXHR !== "undefined"){optionsSwal = simple_cms.ajaxError(settings.jqXHR);}optionsSwal.icon = "warning";optionsSwal.showCancelButton = true;optionsSwal.cancelButtonColor = "#EB4329";optionsSwal.cancelButtonText = "Close";optionsSwal.showConfirmButton = false;optionsSwal.reverseButtons = true;optionsSwal.allowOutsideClick = false;Swal.fire(optionsSwal);$('#page-loader').removeClass('show').addClass('d-none');};
    window.LaravelDataTables = window.LaravelDataTables || {};
    @foreach($editors as $editor)
        var {{$editor->instance}} = window.LaravelDataTables["%1$s-{{$editor->instance}}"] = new $.fn.dataTable.Editor({!! $editor->toJson() !!});
        {!! $editor->scripts  !!}
        @foreach ((array) $editor->events as $event)
            {{$editor->instance}}.on('{!! $event['event']  !!}', {!! $event['script'] !!});
        @endforeach
    @endforeach
    window.LaravelDataTables["%1$s"] = $("#%1$s").DataTable(%2$s);
})(window,jQuery);
