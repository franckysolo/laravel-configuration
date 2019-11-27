@if (Session::has('success'))
  <div class="alert alert-success mt-4">
    {{ Session::get('success') }}
  </div>
@endif

@if (Session::has('warning'))
  <div class="alert alert-warning mt-4">
    {{ Session::get('warning') }}
  </div>
@endif

@if (Session::has('info'))
  <div class="alert alert-info mt-4">
    {{ Session::get('info') }}
  </div>
@endif

@if (Session::has('error'))
  <div class="alert alert-danger mt-4">
    {{ Session::get('error') }}
  </div>
@endif
