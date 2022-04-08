$(document).ready(function () {

    $('#sortableSlider').sortable({
        stop: function(event, ui) {
            var target = $('#sortableSlider'),
                url = target.data('action'),
                params = target.serializeJSON();
            $.ajax({
                url: url, type: 'POST', typeData: 'json', cache: false, data: params,
                beforeSend : function(r){
                    // $('.indicator_sorter_slider').html('<i class="fa fa-refresh fa-spin fa-2x"></i>');
                },
                success: function (res) {
                    // $('.indicator_sorter_slider').html('');
                }
            });
        }
    });
    $( "#sortableSlider" ).disableSelection();

    $(document).on('click','.forceDelete',function (e) {
        var self = $(this),
            url = self.attr('data-action'),
            params = self.attr('data-value');
        if(typeof params === 'string'){
            params = JSON.parse(params);
        }
        /*swal({
                title: "Delete Data.!",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#da4137",
                confirmButtonText: "Delete.!",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                html:true
            },
            function(isConfirm) {
                if(isConfirm) {
                    $.ajax({
                        url: url, type:'POST', typeData:'json',  cache:false, data:params,
                        success: function(response){
                            cms.responseMessageWithSwal(response);
                            self.parent().parent().remove();
                        }
                    });
                }
            });*/
    });
});
