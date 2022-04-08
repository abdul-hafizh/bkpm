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
                dialog: {width: 900, modal: true, title: 'Select a file'},
                resizable: false,
                height: '100%',
                /*commandsOptions: {
                    getfile: {
                        oncomplete: 'destroy'
                    }
                },*/
                getFileCallback: function (file) {
                    file.url = file.url.replace('http://', '//').replace('https://', '//');
                    window.parent.processSelectedFile(file.url, '{{ $input_id  }}');
                    parent.jQuery.colorbox.close();
                }
            }).elfinder('instance');
        });
    </script>
@stop
