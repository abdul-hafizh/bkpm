@extends('core::layouts.mail')
@section('title',$data['subject'])

@section('content')
    <!-- begin row -->
    <table class="row">
        <tr>
            <td class="wrapper">
                <!-- begin twelve columns -->
                <table class="twelve columns">
                    <tr>
                        <td>
                            <h4 class="center">{{ $data['subject'] }}</h4>
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
                            <p>Hello <strong>{{ $data['name'] }}</strong>,</p>
                            <p>Your password has been updated/changed.</p>
                            <table class="table-no-padding">
                                <tr>
                                    <td>Time</td>
                                    <td>: {{ $data['updated_at'] }}</td>
                                </tr>
                                <tr>
                                    <td>IP</td>
                                    <td>: {{ $data['user_ip'] }}</td>
                                </tr>
                                <tr>
                                    <td>User Agent</td>
                                    <td>: <strong>{{ $data['user_agent'] }}</strong></td>
                                </tr>
                            </table>
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