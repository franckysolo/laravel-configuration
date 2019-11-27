@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>{{ __('My settings') }}</h1>
    <div class="text-right">
      <a href="{{ route('configurations.create') }}" class="btn btn-primary">
        <span class="fas fa-edit"></span>
        {{ __('Add a configuration variable') }}
      </a>
    </div>
    @if (config('configuration.enable_toast'))
      @include('configurations::toast')
    @endif
    @include('configurations::table')
  </div>
@endsection
