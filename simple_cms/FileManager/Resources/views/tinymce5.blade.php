@extends('filemanager::filemanager')
@section('elfinder_script')
    {{-- elFinder initialization (REQUIRED) --}}
    <script type="text/javascript">
        var FileBrowserDialogue = {
            init: function() {
                // Here goes your code for setting your custom things onLoad.
            },
            mySubmit: function (file) {
                window.parent.postMessage({
                    mceAction: 'fileSelected',
                    data: {
                        file: file
                    }
                }, '*');
            }
        };

        $().ready(function() {
            var elf = $('#elfinder').elfinder({
                // set your elFinder options here
                @if($locale)
                lang: '{{ $locale }}', // locale
                @endif
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url: '{{ $url_connector }}',  // connector URL
                soundPath: '{{ asset($dir.'/sounds') }}',
                height: '100%',
                getFileCallback: function(file) { // editor callback
                    file.url = file.url.replace('http://', '//').replace('https://', '//');
                    FileBrowserDialogue.mySubmit(file); // pass selected file path to TinyMCE
                }
            }).elfinder('instance');
        });
    </script>
@stop
