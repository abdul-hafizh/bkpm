@extends('filemanager::filemanager')
@section('elfinder_script')
    <script type="text/javascript">
        var FileBrowserDialogue = {
            init: function() {
                // Here goes your code for setting your custom things onLoad.
            },
            mySubmit: function (URL) {
                var win = tinyMCEPopup.getWindowArg('window');

                // pass selected file path to TinyMCE
                win.document.getElementById(tinyMCEPopup.getWindowArg('input')).value = URL;

                // are we an image browser?
                if (typeof(win.ImageDialog) != 'undefined') {
                    // update image dimensions
                    if (win.ImageDialog.getImageData) {
                        win.ImageDialog.getImageData();
                    }
                    // update preview if necessary
                    if (win.ImageDialog.showPreviewImage) {
                        win.ImageDialog.showPreviewImage(URL);
                    }
                }

                // close popup window
                tinyMCEPopup.close();
            }
        }

        tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);

        $().ready(function() {
            var elf = $('#elfinder').elfinder({
                // set your elFinder options here
                @if($locale)
                    lang: '{{ $locale }}', // locale
                @endif
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url : '{{ $url_connector }}',  // connector URL
                soundPath: '{{ asset($dir.'/sounds') }}',
                height: '100%',
                getFileCallback: function(file) { // editor callback
                    file.url = file.url.replace('http://', '//').replace('https://', '//');
                    FileBrowserDialogue.mySubmit(file.url); // pass selected file path to TinyMCE
                }
            }).elfinder('instance');
        });
    </script>
@stop
