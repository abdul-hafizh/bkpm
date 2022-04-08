@extends('filemanager::filemanager')
@section('elfinder_script')
    {{-- elFinder initialization (REQUIRED) --}}
    <script type="text/javascript" charset="utf-8">
        {{-- Helper function to get parameters from the query string. --}}
        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
            var match = window.location.search.match(reParam) ;

            return (match && match.length > 1) ? match[1] : '' ;
        }

        $().ready(function() {
            var funcNum = getUrlParam('CKEditorFuncNum');

            var elf = $('#elfinder').elfinder({
                {{-- set your elFinder options here --}}
                        @if($locale)
                lang: '{{ $locale }}', // locale
                @endif
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url: '{{ $url_connector }}',  // connector URL
                soundPath: '{{ asset($dir.'/sounds') }}',
                height: '100%',
                getFileCallback : function(file) {
                    window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
                    window.close();
                }
            }).elfinder('instance');
        });
    </script>
@stop