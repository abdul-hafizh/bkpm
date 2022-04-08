@extends('filemanager::filemanager')
@section('elfinder_script')
    <!-- Include jQuery, jQuery UI, elFinder (REQUIRED) -->
    <script type="text/javascript">
        $().ready(function () {
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
                resizable: false,
                ui: ['toolbar', 'path','stat'],
                onlyMimes: [{{ $mimeTypes }}],
                rememberLastDir : false,
                height: '100%',
                defaultView: 'list',
                getFileCallback: function (file) {
                    window.parent.processSelectedFile(file, '{{ $input_id }}');
                },
                uiOptions : {
                    // toolbar configuration
                    toolbar : [
                        ['home', 'up'],
                        ['upload'],
                        ['quicklook'],
                    ],
                    // directories tree options
                    tree : {
                        // expand current root on init
                        openRootOnLoad : true,
                        // auto load current dir parents
                        syncTree : true
                    },
                    // navbar options
                    navbar : {
                        minWidth : 150,
                        maxWidth : 500
                    },
                    // current working directory options
                    cwd : {
                        // display parent directory in listing as ".."
                        oldSchool : false
                    }
                }
            }).elfinder('instance');
        });
    </script>
@stop
