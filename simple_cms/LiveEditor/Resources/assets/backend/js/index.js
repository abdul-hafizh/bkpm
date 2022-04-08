let $openFiles = [];
let liveeditor = null;
let cntFile;
let modelist = ace.require("ace/ext/modelist");
let Range = ace.require("ace/ext/range");
let $laetabs = $(".liveeditor-tabs");

$(function () {
    // Start Jquery File Tree
    $('.la-file-tree').fileTree({
        root: $('#liveeditor').attr('data-dir'),
        script: simple_cms._url + "/backend/live-editor/get-dir?_token=" + simple_cms.tokenCsrf
    }, function(file) {
        openFile(file);
        // do something with file
        // $('.selected-file').text( $('a[rel="'+file+'"]').text() );
    });

    // Start Ace editor
    liveeditor = ace.edit("la-ace-editor");
    liveeditor.setTheme("ace/theme/twilight");
    liveeditor.session.setMode("ace/mode/javascript");
    liveeditor.$blockScrolling = Infinity;
    liveeditor.commands.addCommand({
        name: 'save',
        bindKey: {win: "Ctrl-S", "mac": "Cmd-S"},
        exec: function(editor) {
            // console.log("saving", editor.session.getValue());
            saveFileCode(cntFile, editor.session.getValue(), false);
        }
    });

    setEditorSize();

    $(window).resize(function() {
        setEditorSize();
    });

    $('#saveLiveEditor').on('click',function (e) {
        saveFileCode(cntFile, liveeditor.session.getValue(), false);
    });
});
function setEditorSize() {
    let windowHeight = $(window).height();
    let editorHeight = windowHeight-50-31;
    let treeHeight = windowHeight-70-21;
    // console.log("windowHeight	: "+windowHeight);
    // console.log("editorHeight: "+editorHeight);
    // console.log("treeHeight: "+treeHeight);

    $(".la-file-tree").height(treeHeight+"px");
    $("#la-ace-editor").css("height", editorHeight+"px");
    $("#la-ace-editor").css("max-height", editorHeight+"px");
}

$(".liveeditor-tabs").on("click", "li a i.fa", function(e) {
    let filepath = $(this).parent().attr("filepath");
    closeFile(filepath);
    e.stopPropagation();
});
$(".liveeditor-tabs").on("click", "li a", function(e) {
    let filepath = $(this).attr("filepath");
    openFile(filepath);
    e.stopPropagation();
});

function openFile(filepath) {
    let fileFound = fileContains(filepath);
    // console.log("openFile: "+filepath+" fileFound: "+fileFound);

    loadFileCode(filepath, false);
    // console.log($openFiles);
}

function closeFile(filepath) {
    // console.log("closeFile: "+filepath);
    // $openFiles[getFileIndex(filepath)] = null;
    let index = getFileIndex(filepath);
    // console.log("index: "+index);
    $openFiles.splice(index, 1);
    $laetabs.children("li[filepath='"+filepath+"']").remove();
    // console.log($openFiles);

    if(index !== 0 && $openFiles.length !== 0) {
        openFile($openFiles[index-1].filepath);
    } else {
        liveeditor.setValue("", -1);
        liveeditor.focus();
        liveeditor.session.setMode("ace/mode/text");
        cntFile = "";
    }
}

function loadFileCode(filepath, reload) {
    // console.log("loadFileCode: "+filepath+" contains: "+fileContains(filepath));
    if(!fileContains(filepath)) {
        $.ajax({
            url: simple_cms._url + "/backend/live-editor/get-file",
            method: 'POST',
            data: {"filepath": filepath},
            async: false,
            success: function( res ) {
                res = res.body;
                $('meta[name="_token"]').attr('content',res._token);

                liveeditor.setValue(res.data, -1);
                liveeditor.focus();

                let mode = modelist.getModeForPath(filepath).mode;
                liveeditor.session.setMode(mode);

                // $openFiles[getFileIndex(filepath)].filedata = data;
                // $openFiles[getFileIndex(filepath)].filemode = mode;

                $file = {
                    "filepath": filepath,
                    "filedata": res.data,
                    "filemode": mode
                };
                $openFiles.push($file);
                let filename = filepath.replace(/^.*[\\\/]/, '');
                $laetabs.append('<li filepath="'+filepath+'"><a class="hover" filepath="'+filepath+'">'+filename+' <i class="fa fa-times"></i></a></li>');
                highlightFileTab(filepath);
            }
        });
    } else {
        // console.log("File found offline");
        let data = $openFiles[getFileIndex(filepath)].filedata;
        liveeditor.setValue(data, -1);
        liveeditor.focus();
        let mode = modelist.getModeForPath(filepath).mode;
        liveeditor.session.setMode(mode);
        highlightFileTab(filepath);
    }
}

function saveFileCode(filepath, filedata, reload) {
    // console.log("saveFileCode: "+filepath);
    if(filepath !== "" && filedata !== "") {
        $(".liveeditor-tabs li a[filepath='"+filepath+"'] i.fa").removeClass("fa-times").addClass("fa-spin").addClass("fa-refresh");

        $.ajax({
            url: simple_cms._url + "/backend/live-editor/save-file",
            method: 'POST',
            data: {
                "filepath": filepath,
                "filedata": filedata
            },
            success: function( response ) {
                if (typeof response.body !== "undefined") {
                    let data = response.body;
                    $('meta[name="_token"]').attr('content', data._token);
                    if (data.success === false) {
                        Swal.fire(data.message);
                    } else {
                        $(".liveeditor-tabs li a[filepath='" + filepath + "'] i.fa").removeClass("fa-spin").removeClass("fa-refresh").addClass("fa-times");
                        simple_cms.responseMessageWithSwalConfirmReloadOrNot(response);
                    }
                }else{
                    Swal.fire('Internal Server Error');
                }
            }
        });
    }
}

function highlightFileTab(filepath) {
    cntFile = filepath;
    $laetabs.children("li").removeClass("active");
    $laetabs.children("li[filepath='"+filepath+"']").addClass("active");
}

function getFileIndex(filepath) {
    for (let i=0; i < $openFiles.length; i++) {
        if($openFiles[i].filepath === filepath) {
            return i;
        }
    }
}

function fileContains(filepath) {
    for (let i=0; i < $openFiles.length; i++) {
        if($openFiles[i].filepath === filepath) {
            return true;
        }
    }
    return false;
}