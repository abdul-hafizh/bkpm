$(function () {
    let elmNestable = $('#nestable3');
    const setIndexMenuNestable = function() {
            $.each($('#nestable3').find('li'), function (ind, val) {
                ind += 1;
                $(this).attr('data-id', ind);
                $(this).find('div[data-toggle="collapse"]').attr({
                    'data-target': '#collapseNestableID'+ind,
                    'aria-controls': 'collapseNestableID'+ind,
                });
                $(this).find('div.collapse').attr({
                    'id': 'collapseNestableID'+ind,
                });
            });
        },
        nestableActive = () => {
            return elmNestable.nestable({
                maxDepth: 4
            }).on('change', function(e) {
                setIndexMenuNestable();
            });
        },
        initMenuNestable = function() {
            nestableActive();
        },
        resourceMenuNestable = function() {
            return elmNestable.nestable('serialize');
        },
        countMenuNestable = function() {
            return $('#nestable3').find('li').length;
        },
        tplFormEditMenu = (data) => {
            let replaceInputLanguageLabel = $(templateInputLanguageLabel),
                replaceInputLanguageTitle = $(templateInputLanguageTitle),
                getIDLabel = $('ul', replaceInputLanguageLabel).attr('id'),
                getIDTitle = $('ul', replaceInputLanguageTitle).attr('id');
            getIDLabel = getIDLabel.replace('tabLang-', '');
            getIDTitle = getIDTitle.replace('tabLang-', '');
            let regexLabel = new RegExp(getIDLabel, 'g'),
                regexTitle = new RegExp(getIDTitle, 'g');

            replaceInputLanguageLabel = $( templateInputLanguageLabel.replace(regexLabel, getIDLabel + "_" + data.id) );
            replaceInputLanguageTitle = $( templateInputLanguageTitle.replace(regexTitle, getIDTitle + "_" + data.id) );

            $.each(replaceInputLanguageLabel.find('input'), function(){
                let getAttrID = $(this).attr('id'),
                    getAttrName = $(this).attr('name'),
                    getAttrNameLocale = getAttrName.replace('label[', '').replace(']', '');
                $(this).attr('id', getAttrID + "_" + data.id);
                $(this).attr('value', (typeof data.label[getAttrNameLocale] !== "undefined" ? data.label[getAttrNameLocale] : data.label));
            });
            $.each(replaceInputLanguageTitle.find('input'), function(){
                let getAttrID = $(this).attr('id'),
                    getAttrName = $(this).attr('name'),
                    getAttrNameLocale = getAttrName.replace('title[', '').replace(']', '');
                $(this).attr('id', getAttrID + "_" + data.id);
                $(this).attr('value', (typeof data.title[getAttrNameLocale] !== "undefined" ? data.title[getAttrNameLocale] : data.title));
            });

            let html = '<form class="formEditMenu row"><input type="hidden" name="id" value="'+ data.id +'"> \n' +

                '                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">\n' +
                '                                        <label>Label <strong class="text-danger">*</strong></label>\n' +
                replaceInputLanguageLabel.get(0).outerHTML +
                //'                                        <input name="label" type="text" value="'+ data.label +'" class="form-control form-control-sm" required placeholder="Label">\n' +
                '                                    </div>\n' +
                '                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">\n' +
                '                                        <label>Title Attribute</label>\n' +
                replaceInputLanguageTitle.get(0).outerHTML +
                //'                                        <input name="title" type="text" value="'+ (data.title !== null ? data.title : '') +'" class="form-control form-control-sm" placeholder="Title Attribute">\n' +
                '                                    </div>\n';
            if (data.type !== 'route') {
                html += '                            <div class="form-group col-12">\n' +
                    '                                    <label>URL <strong class="text-danger">*</strong></label>\n' +
                    '                                    <input name="url" type="text" value="' + data.url + '" class="form-control form-control-sm" required placeholder="http://urldomain.com">\n' +
                    '                                </div>\n';
            }else {
                html += '                             <input name="url" type="hidden" value="' + data.url + '" required placeholder="http://urldomain.com">';
            }
        html += '                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">\n' +
                '                                        <label>Icon (<small>Use FontAwesome icon</small>)</label>\n' +
                '                                        <input name="icon" type="text" value="'+ (data.icon !== null ? data.icon : '') +'" class="form-control form-control-sm" placeholder="fas fa-icon">\n' +
                '                                    </div>\n' +
                '                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">\n' +
                '                                        <label>CSS Class</label>\n' +
                '                                        <input name="classcss" type="text" value="'+ (data.classcss !== null ? data.classcss : '') +'" class="form-control form-control-sm" placeholder="CSS Class">\n' +
                '                                    </div>\n' +
                '                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">\n' +
                '                                        <label>Target <strong class="text-danger">*</strong></label>\n' +
                '                                        <select name="target" class="form-control form-control-sm" required>\n' +
                '                                            <option value="_self" '+ (data.target === "_self" ? 'selected':'') +'>_self</option>\n' +
                '                                            <option value="_blank" '+ (data.target === "_blank" ? 'selected':'') +'>_blank</option>\n' +
                '                                            <option value="_parent" '+ (data.target === "_parent" ? 'selected':'') +'>_parent</option>\n' +
                '                                            <option value="_top" '+ (data.target === "_top" ? 'selected':'') +'>_top</option>\n' +
                '                                        </select>\n' +
                '                                    </div>\n' +
                '                                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">\n' +
                '                                        <label>Status <strong class="text-danger">*</strong></label>\n' +
                '                                        <select name="status" class="form-control form-control-sm" required>\n' +
                '                                            <option value="1" '+ (data.status === "1" ? 'selected':'') +'>Show</option>\n' +
                '                                            <option value="0" '+ (data.status === "0" ? 'selected':'') +'>Hide</option>\n' +
                '                                        </select>\n' +
                '                                    </div>\n' +
                '                                    <input name="type" type="hidden" value="'+ data.type +'">\n' +
                '                                    <div class="form-group text-right col-12">' +
                '                                        <button type="button" title="Delete" class="btn btn-xs btn-danger deleteNestableMenu"><i class="fas fa-remove"></i> Delete</button>\n' +
                '                                        <button type="submit" title="Done" class="btn btn-xs btn-success"><i class="fas fa-check"></i> Done</button>\n' +
                '                                    </div>\n' +
                '                            </form>';
            return html;
        },
        addToMenuNestable = function($data) {
            let attributes = '',
                html = '';
            if (typeof $data.id === "undefined"){
                $data.id = (countMenuNestable() + 1);
            }
            $.each($data, function (index, val) {
                if (index !== 'children') {
                    attributes += 'data-' + index + '=\'' + (typeof val === 'object' ? JSON.stringify(val) : val) + '\' ';
                }
            });
            html += '<li class="dd-item dd3-item" ' + attributes + '>\n' +
                '                                <div class="dd-handle dd3-handle"></div>\n' +
                '                                <div class="dd3-content" ' + ($data.status === '0' ? 'style="background:#eabb64d4!important;"' : '') + '>\n' +
                '                                   <span class="set-icon-nestable">' + ($data.icon !== '' ? '<i class="' + $data.icon + '"></i>' : '') + '</span> ' + '<span class="set-label-nestable">' + (typeof $data.label[defaultLocale] !== "undefined" ? $data.label[defaultLocale] : $data.label) + '</span> \n' +
                '                                         <span class="type-menu-nestable text-cyan">' + $data.type + '</span>\n' +
                '                                </div>\n' +
                '                                <div class="dd-handle-right dd3-handle-right collapsed" data-toggle="collapse" data-target="#collapseNestableID'+ (countMenuNestable() + 1) +'" aria-expanded="false" aria-controls="collapseNestableID'+ (countMenuNestable() + 1) +'"></div>\n' +
                '                                 <div class="collapse collapseNestable p-5" id="collapseNestableID'+ (countMenuNestable() + 1) +'">'+ tplFormEditMenu($data) +'</div>\n';
            if ($data.children) {
                html += '<ol class="dd-list">';
                $.each($data.children, function (ind, val) {
                    html += addToMenuNestable(val);
                });
                html += '</ol>';
            }
            html += '                            </li>';
            return html;
        },
        hasMenus = function() {
            let data = resourcesNestable,
                html = '';
            data = (typeof data === 'string' ? JSON.parse(data) : data);
            $.each(data, function (ind, val) {
                html += addToMenuNestable(val);
            });
            $('#nestable3 > ol').append(html);
            setIndexMenuNestable();
        };

    $(document).ready(function () {
        hasMenus();
        initMenuNestable();

        $(document).on('submit','#formCategory', function (e) {
            e.preventDefault();
            let self = $(this),
                html = '',
                data = self.serializeJSON();
            if(typeof data.categories !== "undefined") {
                $.each(data.categories,function (ind, val) {
                   val = (typeof val === 'string' ? JSON.parse(val) : val);
                    html += addToMenuNestable(val);
                });
                $('#nestable3 > ol').append(html);
                simple_cms.ToastSuccess('Category Menu added');
            }
            self[0].reset();
        });

        $(document).on('submit','#formTag', function (e) {
            e.preventDefault();
            let self = $(this),
                html = '',
                data = self.serializeJSON();
            if(typeof data.tags !== "undefined") {
                $.each(data.tags,function (ind, val) {
                    val = (typeof val === 'string' ? JSON.parse(val) : val);
                    html += addToMenuNestable(val);
                });
                $('#nestable3 > ol').append(html);
                simple_cms.ToastSuccess('Tag Menu added');
            }
            self[0].reset();
        });

        $(document).on('submit','#formPages',function (e) {
            e.preventDefault();
            let self = $(this),
                html = '',
                data = self.serializeJSON();
            if(typeof data.pages !== "undefined") {
                $.each(data.pages,function (ind, val) {
                    val = (typeof val === 'string' ? JSON.parse(val) : val);
                    html += addToMenuNestable(val);
                });
                $('#nestable3 > ol').append(html);
                simple_cms.ToastSuccess('Page Menu added');
            }
            self[0].reset();
        });

        $(document).on('submit','#formCustomLink',function (e) {
            e.preventDefault();
            let self = $(this),
                html = '',
                data = self.serializeJSON();
            html += addToMenuNestable(data);
            $('#nestable3 > ol').append(html);
            simple_cms.ToastSuccess('Custom Menu added');
            self[0].reset();
        });

        $(document).on('submit','.formEditMenu',function (e) {
            e.preventDefault();
            let self = $(this),
                data = self.serializeJSON(),
                selectedSelector= $('li.dd-item[data-id="'+data.id+'"] > .dd3-content'),
                label = (typeof data.label[currentLocale] !== "undefined" ? data.label[currentLocale] : data.label);
            selectedSelector.find('.set-label-nestable').html(label);
            if (data.icon !== ''){
                selectedSelector.find('.set-icon-nestable').html('<i class="'+data.icon+'"></i>');
            }
            $('li.dd-item[data-id="'+data.id+'"]').data(data);
            simple_cms.ToastSuccess('Menu changed');
            $(`div[data-target='#collapseNestableID${data.id}']`).trigger('click');
        });

        $(document).on('click','.deleteNestableMenu',function (e) {
            let self = $(this);
            Swal.fire({
                title: 'Delete Menu!?',
                text: '',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#da4137",
                confirmButtonText: "Delete!",
                closeOnConfirm: true,
                reverseButtons: true,
                preConfirm: () => {
                },
                allowOutsideClick: false
            }).then((result) => {
                if (result.value) {
                    self.parent().parent().parent().parent('li').remove();
                    simple_cms.ToastSuccess('Menu deleted');
                }
            });
        });

        $(document).on('click','.btnSaveMenuNestable',function (e) {
            e.preventDefault();
            let url = $(this).data('action'),
                menu_id = $('input#menu_id[name=id]').val(),
                menu_name = $('input#menu_name[name=name]').val(),
                params = {
                    id: menu_id,
                    name: menu_name,
                    option:resourceMenuNestable(),
                    status:1
                };
            if (menu_name === ""){
                Swal.fire('Menu name must be field');
                return false;
            }
            $.ajax({
                url: url, type: 'POST', typeData: 'json', cache: false, data: params,
                success: function (res) {
                    simple_cms.responseMessageWithSwalConfirmReloadOrRedirect(res);
                }
            });
        });

    });
});
