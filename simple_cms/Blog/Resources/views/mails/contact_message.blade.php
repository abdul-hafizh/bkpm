@extends('core::layouts.mail')
@section('title', $data['subject'])

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
                            <p>Pengirim,</p>
                            <p>
                                Nama: <strong>{{ $data['name'] }}</strong><br/>
                                Email: <strong>{{ $data['email'] }}</strong>
                                @if(isset($data['phone']) && $data['phone'])
                                    <br/>
                                    Phone: <strong>{{ $data['phone'] }}</strong>
                                @endif
                                @if(isset($data['website']) && $data['website'])
                                    <br/>
                                    Website: <strong>{{ $data['website'] }}</strong>
                                @endif
                                @if(isset($data['subject_message']) && $data['subject_message'])
                                    <br/>
                                    Subject: <strong>{{ $data['subject_message'] }}</strong>
                                @endif
                            </p>
                            <p>Pesan:</p>
                            <p>{{ $data['message'] }}</p>
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