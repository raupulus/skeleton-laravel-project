@extends('mail.layouts.base')
@section('content')
<h2 style="color: #1f2937;">{{ $mailSubject }}</h2>
<div>{!! $mailContent !!}</div>
@endsection
