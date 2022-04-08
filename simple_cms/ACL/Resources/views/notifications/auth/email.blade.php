@extends('core::layouts.mail')
@section('title',$subject)

@section('content')
    <!-- begin row -->
    <table class="row">
        <tr>
            <td class="wrapper">
                <!-- begin twelve columns -->
                <table class="twelve columns">
                    <tr>
                        <td>
                            <h4 class="center">{{ $subject }}</h4>
                        </td>
                        <td class="expander"></td>
                    </tr>
                </table>
                <!-- end twelve columns -->
            </td>
        </tr>
    </table>
    <!-- end row -->
    <!-- begin divider -->
    <table class="divider"></table>
    <!-- end divider -->
    <!-- begin row -->
    <table class="row">
        <tr>
            <td class="wrapper">
                <!-- begin twelve columns -->
                <table class="twelve columns">
                    <tr>
                        <td>
                            <p><strong>Hello !,</strong></p>
                            <p>{{ $description_1 }}</p>
                            <table class="btn primary" align="center">
                                <tr>
                                    <td>
                                        <a href="{{ $link }}">Reset Password</a>
                                    </td>
                                </tr>
                            </table>
                            <br/>
                            <p>{{ $description_2 }}</p>
                            <p>{{ $description_3 }}</p>
                        </td>
                        <td class="expander"></td>
                    </tr>
                </table>
                <!-- end twelve columns -->
            </td>
        </tr>
    </table>
    <!-- end row -->
    <!-- begin divider -->
    <table class="divider"></table>
    <!-- end divider -->
    <!-- begin row -->
    <table class="row">
        <tr>
            <td class="wrapper">
                <!-- begin twelve columns -->
                <table class="twelve columns">
                    <tr>
                        <td>
                            @lang(
                                "If you’re having trouble clicking the Reset Password button, copy and paste the URL below\n".
                                'into your web browser: '
                            )
                            <br/>
                            <a href="{{ $link }}">{{ $link }}</a>
                        </td>
                        <td class="expander"></td>
                    </tr>
                </table>
                <!-- end twelve columns -->
            </td>
        </tr>
    </table>
    <!-- end row -->
@endsection