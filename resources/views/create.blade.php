@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>{{ $title }}</h1>
    <div class="text-right">
      <a href="{{ route('configurations.index') }}" class="btn btn-primary">
        <span class="fas fa-back"></span>
        {{ __('Retour à la liste') }}
      </a>
    </div>
    @if (config('configuration.enable_toast'))
      @include('configurations::toast')
    @endif
    @include('configurations::form')
  </div>
@endsection
