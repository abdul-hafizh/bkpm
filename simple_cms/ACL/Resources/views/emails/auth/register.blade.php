@extends('core::layouts.mail')
@section('title','New Register Account')

@section('content')
    <!-- begin row -->
    <table class="row">
        <tr>
            <td class="wrapper">
                <!-- begin twelve columns -->
                <table class="twelve columns">
                    <tr>
                        <td>
                            <h4 class="center">New Register Account</h4>
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
                            <p>Welcome</p>
                            <table class="table-no-padding">
                                <tr>
                                    <td>Name</td>
                                    <td>: {{ $data['name'] }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>: {{ $data['email'] }}</td>
                                </tr>
                                <tr>
                                    <td>Username</td>
                                    <td>: <strong>{{ $data['username'] }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td>: <strong><i>hidden</i></strong></td>
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