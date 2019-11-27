<div class="table-responsive mt-4">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>@lang('Parameter')</th>
          <th>@lang('Description')</th>
          <th>@lang('Type')</th>
          <th>@lang('Value')</th>
          <th>@lang('Action')</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($configurations as $configuration)
          <tr>
            <td>{{ $configuration->name }}</td>
            <td>{{ $configuration->description }}</td>
            <td>{{ $configuration->type }}</td>
            <td>{{ $configuration->value }}</td>
            <td>
              <a title="{{ __('Edit') }}" href="{{ route('configurations.edit', $configuration) }}" class="btn btn-link">
                <span class="fas fa-edit"></span>
                {{ __('Edit') }}
              </a>
              <form class="form-inline d-inline-block" method="post"
                action="{{ route('configurations.destroy', $configuration) }}">
                @csrf
                @method('DELETE')
                <button title="{{ __('Delete') }}" class="btn btn-link">
                  <span class="fas fa-trash-alt"></span>
                  {{ __('Delete') }}
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <th colspan="5">{{ __('No configurations values') }}</th>
          </tr>
        @endforelse
      </tbody>
    </table>
</div>
