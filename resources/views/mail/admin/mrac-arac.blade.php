@extends('mail.layout.default')
@section('title', $emailContent['subject'])
@section('content')
<div class="wrap-content" style="color: #000000;">
    <p>{{ $emailContent['body'] }}</p>
    <p>Details of the submission:</p>
    <ul>
        <li>Date/Time of Submission: {{ $data['time'] }}</li>
        <li>Submitted by: {{ $data['name'] }}</li>
        <li>User Email Address: {{ $data['email'] }}</li>
        <li>County Designation: {{ $data['county_designation'] }}</li>
    </ul>
    <p><a href="{{ url('/county-mrac-arac')}}" target="_blank" class="btn-confirm">{{ $emailContent['button_title'] }}</a></p>
</div>
@endsection
