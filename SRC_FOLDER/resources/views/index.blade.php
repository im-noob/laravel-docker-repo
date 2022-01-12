@extends('main')
@section('content')
    @if(session()->has('success'))
        <div class="alert alert-success mt-3" role="alert">
            {{session()->get('success')}}
        </div>
    @endif
    @include('form_component')
@endsection
