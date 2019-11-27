<form method="POST" action="{{ $url }}">
  @csrf
  @method($method)

  <fieldset class="form-group">
    <label for="type">@lang('Type')</label>
    <select class="form-control" id="type" name="type">
      @foreach ($configurationTypes as $key => $type)
      <option value="{{ $key }}" @if ($key == $configuration->type) selected @endif>
        {{ $type }}
      </option>
      @endforeach
    </select>
    @error('type')
      <p class="invalid-feedback">{{ $errors->first('type') }}</p>
    @enderror
  </fieldset>

  <fieldset class="form-group">
    <label for="name">@lang('Parameter name')</label>
    <input type="text" name="name" value="{{ $configuration->name }}" class="form-control @error('name') is-invalid @enderror"
      id="name" placeholder="@lang('Enter the parameter name')">
    @error('name')
      <p class="invalid-feedback">{{ $errors->first('name') }}</p>
    @enderror
  </fieldset>

  <fieldset class="form-group">
    <label for="value">@lang('Parameter value')</label>
    <input type="text" name="value" value="{{ $configuration->value }}" class="form-control @error('value') is-invalid @enderror"
      id="value" placeholder="@lang('Enter the parameter value')">
    @error('value')
      <p class="invalid-feedback">{{ $errors->first('value') }}</p>
    @enderror
  </fieldset>

  <fieldset class="form-group">
    <label for="description">@lang('Description')</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
      id="description" rows="3" placeholder="@lang('Enter the parameter description')">{{ $configuration->description }}</textarea>
    @error('description')
      <p class="invalid-feedback">{{ $errors->first('description') }}</p>
    @enderror
  </fieldset>

  <button type="submit" class="btn btn-primary">{{ $label }}</button>

</form>
