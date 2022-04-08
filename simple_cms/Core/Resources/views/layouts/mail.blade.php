<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ site_name() }}</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    @include('core::partials.mail.asset_mail_css')
</head>
<body>
<!-- begin page body -->
<table class="body">
    <tr>
        <td class="center" align="center" valign="top">
            <center>

                @include('core::partials.mail.header_mail')

                <!-- begin page container -->
                <table class="container content white-theme">
                    <tr>
                        <td>
                            @yield('content')
                            <br />
                        </td>
                    </tr>
                </table>
                <!-- end page container -->
                @include('core::partials.mail.footer_mail')
            </center>
        </td>
    </tr>
</table>
<!-- end page body -->
</body>
</html>
