/*
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/16/20, 6:00 PM ---------
 */

$(document).ready(function(){
    let widgetsDrag     = $('.widgets-drag'),
        widgetsClone    = $('.widgets-clone'),
        widgetsAdded    = $('.widgets-added'),
        widgetsItem     = $('.widgets-item'),
        widgetMoved     = '',
        widgetMovedClosest = '',
        fromWidgetAvailable = false;

    widgetsClone.sortable({
        revert: true,
        handle: '.card-header',
        connectWith: ".widgets-clone",
        start: function(event, ui){
            widgetMoved = $(ui.item);
            widgetMovedClosest = widgetMoved.closest('.widgets-clone');
        },
        stop: function (event, ui) {
            // rebuildWidgetPosition();
            if (fromWidgetAvailable === false) {
                saveWidgets(widgetMovedClosest);
            }
            saveWidgets($(ui.item).closest('.widgets-clone'));
            fromWidgetAvailable = false;
        }
    });

    widgetsDrag.draggable({
        connectToSortable: ".widgets-clone",
        helper: "clone",
        revert: "true",
        zIndex: 500,
        placeholder: "droppable-placeholder",
        start: function( event, ui ){
            fromWidgetAvailable = true;
        }
    });

    widgetsClone.droppable({
        drop: function (event, ui) {
            let drg = $(ui.draggable);
            drg.removeClass('col-md-6 col-lg-6 widgets-drag').addClass('widgets-added');
            drg.css({'width':'100%', 'height':'unset'});
            if (fromWidgetAvailable === true) {
                fromWidgetAvailable = true;
            }
        }
    });

    widgetsItem.disableSelection();

    $(document).on('click', '.eventDeleteWidget', function(e){
        e.stopPropagation();
        let self = $(this),
            closestToParent = self.closest('.widgets-clone'),
            textConfirm = self.attr('title');
        if ( self.hasAttr('label-confirm') ) {
            textConfirm = self.attr('label-confirm');
        }
        if (textConfirm === '' && self.hasAttr('data-original-title')){
            textConfirm = self.attr('data-original-title')
        }
        Swal.fire({
            title: textConfirm,
            text: '',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ff1700",
            confirmButtonText: "Delete.!",
            reverseButtons: true,
            preConfirm: () => {
                self.parent().parent().parent().parent().parent().remove();
            },
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                saveWidgets(closestToParent);
                simple_cms.ToastSuccess(textConfirm + ' success');
            }
        });
    });

    $(document).on('click', '.eventSaveWidget', function(e) {
        e.preventDefault();
        saveWidgets($(this).closest('.widgets-clone'));

    });

    function rebuildWidgetPosition() {
        let widgetClone = $('.widgets-clone');
        widgetClone.each(function() {
            $(this).find('.widgets-item').each(function(index){
                let no = (index + 1);
                $(this).find('input[name=position]').val(no);
            });
        });
    }

    function saveWidgets(parentElement) {
        if (parentElement.length)
        {
            let items = [],
                params = {widgets: [], group: parentElement.attr('data-group')};
            $.each(parentElement.find('.widgets-item'), function (index, widget) {
                items.push($(widget).find('form').serializeJSON());
            });
            params.widgets = items;
            $.ajax({
                url: widgets.routes.save, type:'POST', typeData:'json',  cache:false, data:params,
                success: function(data){
                    simple_cms.ToastSuccess(data);
                }
            });
        }
    }
});
