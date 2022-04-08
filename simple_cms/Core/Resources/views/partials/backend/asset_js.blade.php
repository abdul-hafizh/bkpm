<!-- Bootstrap 4 -->
{!! library_bootstrap('js') !!}
<!-- AdminLTE App -->
{!! module_script('core','js/adminlte.min.js') !!}
{!! module_script('core','js/active-link.js') !!}

<script>
    $(document).ready(function () {
        $('#backend-sidebar').activeLink();
    })
</script>
