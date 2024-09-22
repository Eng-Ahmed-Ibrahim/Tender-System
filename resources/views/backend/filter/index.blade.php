@extends('admin.index')

@section('content')
<div class="container">
    <form action="{{ route('apply.filters', ['cat_id' => $cat_id]) }}" method="GET">
        <div class="container mt-4">
            <h2 class="mb-4">Filters</h2>
    
            @foreach($filters as $filter)
                <div class="mb-3">
                    <label for="{{ $filter->filter_name }}" class="form-label">{{ ucfirst($filter->filter_name) }}</label>
    
                    @if($filter->filter_type == 'text')
                        <input type="text" class="form-control" id="{{ $filter->filter_name }}" name="{{ $filter->filter_name }}" value="{{ request($filter->filter_name) }}">
    
                    @elseif($filter->filter_type == 'number')
                        <input type="number" class="form-control" id="{{ $filter->filter_name }}" name="{{ $filter->filter_name }}" value="{{ request($filter->filter_name) }}">
    
                    @elseif($filter->filter_type == 'select' && !empty($filter->filter_options))
                        <select class="form-select" id="{{ $filter->filter_name }}" name="{{ $filter->filter_name }}">
                            <option value="" disabled {{ !request($filter->filter_name) ? 'selected' : '' }}>Select {{ ucfirst($filter->filter_name) }}</option>
                            @foreach(explode(',', $filter->filter_options) as $option)
                                <option value="{{ trim($option) }}" {{ request($filter->filter_name) == trim($option) ? 'selected' : '' }}>
                                    {{ trim($option) }}
                                </option>
                            @endforeach
                        </select>
    
                    @elseif($filter->filter_type == 'checkbox' && $filter->filter_name == 'features')
                        <div>
                            <h3 class="mb-3">Features</h3>
                            @foreach($features as $feature)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="feature_{{ $feature->id }}" name="features[]" value="{{ $feature->id }}" 
                                    {{ in_array($feature->id, request('features', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_{{ $feature->id }}">
                                        {{ $feature->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
    
                    @elseif($filter->filter_type == 'min_max')
                        <div class="mb-3">
                            <label for="min_{{ $filter->filter_name }}" class="form-label">Min {{ ucfirst($filter->filter_name) }}</label>
                            <input type="number" class="form-control" id="min_{{ $filter->filter_name }}" name="min_{{ $filter->filter_name }}" value="{{ request('min_' . $filter->filter_name) }}"
                                   min="{{ $filter->min_value }}" max="{{ $filter->max_value }}">
    
                            <label for="max_{{ $filter->filter_name }}" class="form-label mt-2">Max {{ ucfirst($filter->filter_name) }}</label>
                            <input type="number" class="form-control" id="max_{{ $filter->filter_name }}" name="max_{{ $filter->filter_name }}" value="{{ request('max_' . $filter->filter_name) }}"
                                   min="{{ $filter->min_value }}" max="{{ $filter->max_value }}">
                        </div>
                    @endif
                </div>
            @endforeach
    
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </div>
    </form>
    
</div>
@endsection
