@extends('layouts.app_copy')
@section('content')

    <h3>hello dashboard page . welcome {{ \Illuminate\Support\Facades\Auth::user()->name }}</h3>

@endsection
